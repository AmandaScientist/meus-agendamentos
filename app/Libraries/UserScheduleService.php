<?php

namespace App\Libraries;

use App\Models\ScheduleModel;
use CodeIgniter\Events\Events;
use Exception;

class UserScheduleService
{

    /** @var ScheduleModel */
    private ScheduleModel $scheduleModel;


    /** Construtor */
    public function __construct()
    {
        $this->scheduleModel = model(ScheduleModel::class);
    }


    /**
     * Renderiza uma lista HTML com os agendamentos do usuário logado.
     *
     * @return string
     */
    public function all(): string
    {

        $schedules = $this->scheduleModel->getLoggedUserSchedules();


        if (empty($schedules)) {


            $anchor = '<div class="alert alert-info mb-4">Você ainda não tem agendamentos</div>';
            $anchor .= anchor(route_to('schedules.new'), 'Criar agendamento', ['class' => 'btn btn-primary']);

            return $anchor;
        }


        $ul = '<ul class="list-group">';


        foreach ($schedules as $schedule) {

            $ul .= '<li class="list-group-item d-flex justify-content-between align-items-start">'; // abri a lib


            $btnCancel = '';

            if ($schedule->canBeCanceled()) {

                $btnCancel .= $this->renderBtnCancel($schedule->id);
                $btnEdit = $this->renderBtnEdit($schedule->id);
                $btnPrint = $this->renderBtnPrint($schedule->id);
            }

            $ul .= "<div class='ms-4 me-auto'>
                    <div class='fw-bold'>{$schedule->unit} {$schedule->address}</div>
                    {$schedule->service}
                    <p>{$btnCancel} {$btnEdit} {$btnPrint}</p>
                </div>";

            $ul .= $schedule->situation();


            $ul .= '</li>';
        }


        $ul .= '</ul>';


        return $ul;
    }


    /**
     * Renderiza o botão HTML para cancelar o agendamento.
     *
     * @param integer|string $id
     * @return string
     */
    private function renderBtnCancel(int|string $id): string
    {

        return form_button([
            'class'         => 'btn btn-danger mt-4 btn-sm btnCancelSchedule',
            'data-schedule' => $id,
        ], 'Cancelar');
    }

    private function renderBtnEdit(int|string $id): string
    {
        $url = route_to('schedules.new', $id); // Substituir 'schedules.edit' pelo nome da rota de edição

        return anchor($url, 'Editar', ['class' => 'btn btn-info mt-4 btn-sm btnEditSchedule']);
    }

    private function renderBtnPrint(int|string $id): string
    {
        // Adicionar o código necessário para a impressão (por exemplo, um link para uma página de impressão)
        $url = '#'; // Substituir '#' pela URL ou rota apropriada para a impressão

        return anchor($url, 'Imprimir', ['class' => 'btn btn-warning mt-4 btn-sm btnPrintSchedule']);
    }

    /**
     * Processa o cancelamento do agendamento do user logado
     *
     * @param integer|string $id
     * @return boolean
     */
    public function cancelUserSchedule(int|string $id): bool
    {
        try {

            $where = [
                'id'       => $id,
                'user_id'  => auth()->user()->id,
                'canceled' => 0, // que ainda não foi cancelado
            ];

            $success = $this->scheduleModel->where($where)->set('canceled', 1)->update();

            if (!$success) {

                throw new Exception("Não foi possível cancelar o agendamento {$id} do usuário");
            }

            $schedule = $this->scheduleModel->where('user_id', auth()->user()->id)->getSchedule($id);


            Events::trigger('schedule_canceled', auth()->user()->email, $schedule);

            return true;
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            return false;
        }
    }
    /**
     * Processa a edição do agendamento do usuário logado
     *
     * @param integer|string $id
     * @param array $data Dados a serem atualizados
     * @return boolean
     */
    public function editUserSchedule(int|string $id, array $data): bool
    {
        try {
            // Verificar (teste) se o usuário tem permissão para editar o agendamento
            $where = [
                'id'      => $id,
                'user_id' => auth()->user()->id,
                'canceled' => 0,
            ];

            $success = $this->scheduleModel->where($where)->update($data);

            if (!$success) {
                throw new Exception("Não foi possível editar o agendamento {$id} do usuário");
            }

            $schedule = $this->scheduleModel->find($id);

            Events::trigger('schedule_edited', auth()->user()->email, $schedule);

            return true;
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);
            return false;
        }
    }

    /**
     * Processa a impressão do agendamento do usuário logado
     *
     * @param integer|string $id
     * @return boolean
     */
    public function printUserSchedule(int|string $id): bool
    {
        try {
            // Lógica para impressão (pode incluir redirecionamento para uma página de impressão)
            $schedule = $this->scheduleModel->find($id);

            // Adicionar a lógica necessária para a impressão aqui (código)

            Events::trigger('schedule_printed', auth()->user()->email, $schedule);

            return true;
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);
            return false;
        }
    }
}
