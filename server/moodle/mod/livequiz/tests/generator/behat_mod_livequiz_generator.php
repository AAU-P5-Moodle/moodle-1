<?php

class behat_mod_livequiz_generator extends behat_generator_base
{
    protected function get_creatable_entities(): array
    {
        return [
            'livequizzes' =>[
                'datagenerator' => 'livequiz',
                'required' => ['id'],
            ],
        ];
    }


    protected function get_livequiz_id(string $quizname): int {
        global $DB;

        if (!$id = $DB->get_field('quiz', 'id', ['name' => $quizname])) {
            throw new Exception('There is no quiz with name "' . $quizname . '" does not exist');
        }
        return $id;
    }
}