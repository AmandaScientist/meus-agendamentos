<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class MyBaseEntity extends Entity
{
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'active' => 'boolean',
    ];

    // se estar ativao ou não
    public function isActivated(): bool
    {
        return $this->active; // true ou false
    }

    public function status(): string
    {
        return $this->isActivated() ?
            '<span class="badge badge-primary">Ativo</span>' :
            '<span class="badge badge-danger">Inativo</span>';
    }

    public function textToAction(): string
    {
        return $this->isActivated() ? 'Desativar' : 'Ativar';
    }

    public function activate(): void // void não faz nada, so seta n objeto
    {
        $this->active = 1;
    }

    public function deactivate(): void
    {
        $this->active = 0;
    }

    // seta a ação de fato
    public function setAction()
    {
        $this->isActivated() ? $this->deactivate() : $this->activate();
    }

    public function createdAt(): string
    {
        return Time::parse($this->created_at)->format('d-m-Y H:i');
    }
}
