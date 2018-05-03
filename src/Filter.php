<?php

namespace zabachok\dataProvider;

abstract class Filter implements IFilter
{
    /**
     * @var array
     */
    protected $form;

    /**
     *
     */
    public function setForm(array $form): IFilter
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTables(): array
    {
        return [];
    }
}