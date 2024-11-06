<?php
/**
 * Unit tests for class livequiz.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;

use advanced_testcase;
use mod_livequiz\models\livequiz;
use ReflectionClass;

/**
 * Test class for livequiz class
 */
final class livequiz_test extends advanced_testcase {
    /**
     * Setup that runs before each test in the file
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }


    /**
     * Tests the function prepare_for_template())
     *
     * @covers \mod_livequiz\classes\models\livequiz::prepare_for_template
     * @dataProvider dataProvider
     * prepare_for_template() should return a stdClass object, data, for use in mustache templates
     * data should have the fields: quizid, quiztitle, numberofquestions, questions.
     */
    public function test_livequiz_prepare_for_template(livequiz $livequiz): void {


        $data = $livequiz->prepare_for_template();

        // Verify correct quizid.
        $this->assertIsInt($data->quizid);
        $this->assertEquals($livequiz->get_id(), $data->quizid);


        // Verify correct quiztitle.
        $this->assertIsString($data->quiztitle);
        $this->assertEquals($livequiz->get_name(), $data->quiztitle);

        // Verify correct numberofquestions.
        $this->assertIsInt($data->numberofquestions);
        $this->assertEquals(count($livequiz->get_questions()), $data->numberofquestions);

        // Verify correct questions.


    }


    private function constructlivequiz(
        int $testId,
        string $quiztitle,
        int $course_id,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified
        ) : livequiz {

        $class = new ReflectionClass(livequiz::class);
        $constructor = $class->getConstructor();
        $constructor->setAccessible(true);
        $object = $class->newInstanceWithoutConstructor();
        return $constructor->invoke($object, $testId, $quiztitle , $course_id, $intro, $introformat, $timecreated, $timemodified);
    }


    public function dataProvider(): array {
            return [
                [$this->constructLivequiz(1, "TestQuiz 1", 2, "This is quiz intro", 1, 5000, 6000)],
                [$this->constructLivequiz(2, "TestQuiz 2", 2, "This is quiz intro", 2, 0, 0)],
                [$this->constructLivequiz(2, "TestQuiz 3", 2, "aøå", 1, 0, 0)],
            ];
    }
}
