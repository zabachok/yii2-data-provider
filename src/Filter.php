<?php

namespace zabachok\dataProvider;

abstract class Filter implements IFilter
{
    /**
     * @var array
     */
    protected $form;

    /**
     * @inheritdoc
     */
    public function setForm(array $form): IFilter
    {
        $this->form = $form;

        return $this;
    }
}