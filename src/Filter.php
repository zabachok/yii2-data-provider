<?php

namespace zabachok\dataProvider;

abstract class Filter implements IFilter
{
    /**
     * @var array
     */
    protected $form;

    /**
     * Filter constructor.
     * @param array $form
     */
    public function __construct(array $form)
    {
        $this->setForm($form);
    }

    /**
     * @inheritdoc
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