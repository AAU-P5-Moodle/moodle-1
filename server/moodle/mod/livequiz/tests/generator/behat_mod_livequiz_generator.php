<?php

class mod_livequiz_generator extends behat_generator_base
{
    protected function get_creatable_entities(): array
    {
        return [
            'livequizzes' =>[
                'datagenerator' => 'livequiz',
                'required' => ['name'],
            ],
        ];
    }
}