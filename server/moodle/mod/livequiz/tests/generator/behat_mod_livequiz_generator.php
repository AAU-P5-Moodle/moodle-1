<?php

//This is behats entrypoint for creating livequiz modules
class behat_mod_livequiz_generator extends behat_generator_base
{
    //Returns an array that defines the modules that can be created by the livequiz generator.
    protected function get_creatable_entities(): array
    {
        //You have to provide an id to create a livequiz from you behat test
        return [
            'livequizzes' =>[
                'datagenerator' => 'livequiz',
                'required' => ['id'],
            ],
        ];
    }

    /** A way for behat to fetch livequiz Activity Module Id
     * @throws dml_exception
     * @throws Exception
     */
    protected function get_livequiz_id(string $quizname): int {
        global $DB;

        if (!$id = $DB->get_field('quiz', 'id', ['name' => $quizname])) {
            throw new Exception('There is no quiz with name "' . $quizname . '" does not exist');
        }
        return $id;
    }
}