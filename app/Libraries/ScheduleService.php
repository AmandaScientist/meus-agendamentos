<?php

namespace App\Libraries;

use App\Entities\Schedule;
use App\Models\ScheduleModel;
use App\Models\ServiceModel;
use App\Models\UnitModel;
use CodeIgniter\Events\Events;
use CodeIgniter\I18n\Time;
use Exception;
use InvalidArgumentException;

class ScheduleService
{

    /**
     * Renderiza a lista com as opções de unidades ativas e que possuam serviços associados para serem escolhidas no agendamento.
     *
     * @return string
     */
    public function renderUnits(): string
    {

        // unidades ativas e com serviços associados
        $where = [
            'active' => 1,
            'services !=' => null,
            'services !=' => '',
        ];

        $units = model(UnitModel::class)->where($where)->orderBy('name', 'ASC')->findAll();

        if (empty($units)) {

            return '<div class="text-info mt-5">Não há Recursos de Apoio disponíveis para agendamento</div>';
        }


        // valor padrão
        $radios = '';


        foreach ($units as $unit) {

            $radios .= '<div class="form-check mb-2">';
            $radios .= "<input type='radio' name='unit_id' data-unit='{$unit->name} \nEndereço: {$unit->address}' value='{$unit->id}' class='form-check-input' id='radio-unit-{$unit->id}'>";
            $radios .= "<label class='form-check-label' for='radio-unit-{$unit->id}'>{$unit->name}<br> Endereço: {$unit->address}</label>";
            $radios .= '</div>';
        }

        // retornamos a pesquisa
        return $radios;
    }


    /**
     * Recupero os serviços associados à unidade informada como um dropdown HTML
     *
     * @param integer $unitId
     * @return string
     */
    public function renderUnitServices(int $unitId): string
    {

        // validamos a existência da unidade, ativa, com serviços
        $unit = model(UnitModel::class)->where(['active' => 1, 'services !=' => null, 'services !=' => ''])->findOrFail($unitId);

        // buscamos os serviços dessa unidade
        $services = model(ServiceModel::class)->whereIn('id', $unit->services)->where('active', 1)->orderBy('name', 'ASC')->findAll();

        if (empty($services)) {

            throw new InvalidArgumentException("Os serviços associados ao recurso {$unit->name} não estão ativos ou não existem");
        }

        $options = [];
        $options[null] = '--- Escolha ---';


        foreach ($services as $service) {

            $options[$service->id] = $service->name;
        }

        return form_dropdown(data: 'service', options: $options, selected: [], extra: ['id' => 'service_id', 'class' => 'form-select']);
    }

    /**
     * Tenta criar o agendamento do user logado
     *
     * @param array $request
     * @throws Exception
     * @return boolean|string
     */
    public function validate_end_time(string $endTime, string $startTime): bool
    {


        // Convert the time strings to DateTime objects for comparison


        $endTimeObj = \DateTime::createFromFormat('H:i', $endTime);


        $startTimeObj = \DateTime::createFromFormat('H:i', $startTime);




        // Check if end time is later than start time


        return $endTimeObj > $startTimeObj;
    }
    public function createSchedule(array $request): bool|string
    {
        try {
            $model = model(ScheduleModel::class);

            $request = (object) $request;

            $currentYear = Time::now()->getYear();

            // terei algo assim: 2023-07-17 15:15
            $startDateTime = "{$currentYear}-{$request->month}-{$request->day} {$request->start_time}";
            $endDateTime = "{$currentYear}-{$request->month}-{$request->day} {$request->end_time}";

            // Check if the chosen time range is valid
            if (!$this->validate_end_time($endDateTime, $startDateTime)) {
                return "O horário de fim deve ser posterior ao horário de início";
            }

            // Check if the chosen time range is available
            if (!$model->chosenDateRangeIsFree(unitId: $request->unit_id, startDateTime: $startDateTime, endDateTime: $endDateTime)) {
                return "O intervalo de horário escolhido não está mais disponível";
            }

            $schedule = new Schedule([
                'unit_id'       => $request->unit_id,
                'service_id'    => $request->service_id,
                'start_datetime' => $startDateTime,
                'end_datetime'   => $endDateTime,
            ]);

            // Create the schedule
            if (!$createdId = $model->insert($schedule)) {
                log_message('error', 'Erro ao criar agendamento: ', $model->errors());
                return "Não foi possível criar o agendamento";
            }

            // Trigger an event to send an email to the user with the details of the created schedule
            Events::trigger('schedule_created', auth()->user()->email, $model->getSchedule(id: $createdId));

            // Return true if the schedule was created successfully
            return true;
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);
            return "Internal Server Error";
        }
    }
}
