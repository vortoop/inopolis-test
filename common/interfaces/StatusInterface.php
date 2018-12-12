<?php

namespace common\interfaces;

/**
 * Class StatusInterface
 * @package common\interfaces
 */
interface StatusInterface
{
    const STATUS_ACTIVE = 5;
    const STATUS_NON_ACTIVE = 10;

    /**
     * Установка статуса "Активный"
     */
    public function setStatusActive(): void;

    /**
     * Устанока статуса "Не активный"
     */
    public function setStatusNonActive(): void;

    /**
     * Имеет ли сущность статус "активный"
     * @return bool
     */
    public function isStatusActive(): bool;

    /**
     * Имеет ли сущность статус "не активный"
     * @return bool
     */
    public function isStatusNonActive(): bool;
}
