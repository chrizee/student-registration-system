<?php

namespace app\controllers;

use app\models\Course;
use app\models\Department;
use app\models\Faculty;
use app\models\Registration;
use app\models\Student;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\web\Controller;

class DashboardController extends Controller
{
    public $layout = "new";

    const STUDENT_STATUS = 'S';
    const ADMIN_STATUS = 'A';

    public function behaviors() : array {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->getIdentity();
        if($user->status == self::STUDENT_STATUS) {
            return $this->studentActionIndex($user);
        }else {
           return $this->adminActionIndex();
        }
    }

    public function studentActionIndex($user) {
        $userId = $user->getId();
        $student = Student::find()->where(['user_id' => $userId])->one();
        $registration = Registration::find()->where(['user_id' => $userId])->one();
        if (!empty($student)) {
            $data = [
                'table' => true,
                "student" => $student,
                'registration' => $registration
            ];
            return $this->render("index", $data);
        } else {
            $student = new Student();

            if ($student->load(Yii::$app->request->post()) && $student->validate()) {
                $student->save();
                Yii::$app->session->setFlash("success", "Register your courses");
                $this->redirect(['register-course']);
            }

            return $this->render('index', ['student' => $student, 'table' => false]);
        }
    }

    public function adminActionIndex()
    {
        $pendingReg = Registration::find()->where(['status' => Registration::PENDING ])->count();
        $students = Student::find()->count();
        $faculties = Faculty::find()->count();
        $department = Department::find()->count();
        $data = [
            'pendingRegistration' => $pendingReg,
            'students' => $students,
            'faculties' => $faculties,
            'department' => $department
        ];
        return $this->render('adminindex', $data);
    }

    public function actionFaculties()
    {
        $faculty = new Faculty();

        if($faculty->load(Yii::$app->request->post()) && $faculty->validate()) {
            $faculty->save();
            Yii::$app->getSession()->setFlash('success', 'Faculty added');
            return $this->redirect("index.php?r=dashboard/faculties");
        }
        $faculties = Faculty::find()->all();
        $data = [
            'faculty' => $faculty,
            'faculties' => $faculties
        ];
        return $this->render('faculty', $data);
    }

    public function actionDepartment()
    {
        $department = new Department();

        if($department->load(Yii::$app->request->post()) && $department->validate()) {
            $department->save();
            Yii::$app->getSession()->setFlash('success', 'Department added');
            return $this->redirect("index.php?r=dashboard/department");
        }
        $departments = Department::find()->all();
        $data = [
            'department' => $department,
            'departments' => $departments
        ];
        return $this->render('department', $data);
    }

    /**
     * @return string
     */
    public function actionCourse()
    {
        $course = new Course();

        if($course->load(Yii::$app->request->post()) && $course->validate()) {
            $course->save();
            Yii::$app->getSession()->setFlash('success', 'Course added');
            return $this->redirect("index.php?r=dashboard/course");
        }
        $courses = Course::find()->all();
        $data = [
            'course' => $course,
            'courses' => $courses
        ];
        return $this->render('course', $data);
    }

    /**
     * @return string
     */
    public function actionGetDepartmentFromFacultyAjax($faculty) : string
    {
        $id = Yii::$app->request->getQueryParam("faculty");
        if($id && is_numeric($id)) {
            $departments = Department::find()->where(['faculty_id' => $id])->all();
            if(count($departments) > 0) {
                $output = '';
                foreach ($departments as $department) {
                    $output .= "<option class='".$department->code."' value='" . $department->id . "'>" . $department->name . "</option>";
                }
                return $output;
            }
        }
        return '';
    }

    /**
     * @return string
     */
    public function actionRegisterCourse()
    {
        $userId = Yii::$app->user->getIdentity()->getId();
        $registration = Registration::find()->where(['user_id' => $userId])->one();
        if(!empty($registration)) {
            $in = explode(',', $registration->courses);
            $courses = Course::findAll($in);
            $registrationEdit = new Registration();
            $student = Student::find()->where(['user_id' => $userId])->one();
            $coursesEdit = Course::find()->asArray()->select(['name', 'id'])->indexBy('id')->where(['department_id' => $student->department_id, 'level' => $student->level])->column();
            $data = [
                'table' => true,
                'courses' => $courses,
                "registration" => $registration,
                'registrationEdit' => $registrationEdit,
                'coursesEdit' => $coursesEdit
            ];
            return $this->render("register", $data);
        }else {
            $registration = new Registration();
            $student = Student::find()->where(['user_id' => $userId])->one();
            if(empty($student)) return $this->redirect(['index']);
            $courses = Course::find()->asArray()->select(['name', 'id'])->indexBy('id')->where(['department_id' => $student->department_id, 'level' => $student->level])->column();

            //return Yii::$app->request->post('Registration')['courses'];
            if(!empty(Yii::$app->request->post('Registration')['courses'])) {
                $str = implode(',', Yii::$app->request->post('Registration')['courses']);
                $registration->courses = $str;
                $registration->user_id = Yii::$app->user->getId();
                $registration->status = 0;
            }
            if($registration->validate()) {
                $registration->save();
                Yii::$app->session->setFlash("success", "Registration successful. check you registration status after 24hrs");
                return $this->redirect(['register-course']);
            }
            $data = [
                'registration' => $registration,
                'courses' => $courses,
                'table' => false
            ];
            return $this->render('register', $data);
        }

    }

    public function actionEditCourse($id) {
        $registration = Registration::findOne($id);
        if(!empty(Yii::$app->request->post('Registration')['courses'])) {
            $str = implode(',', Yii::$app->request->post('Registration')['courses']);
            $registration->courses = $str;
            $registration->status = 0;
        }
        if($registration->validate()) {
            $registration->save();
            Yii::$app->session->setFlash("success", "Registration updated");
            return $this->redirect(['register-course']);
        }
        Yii::$app->session->setFlash("error", "Problem updating registration");
        return $this->redirect(['register-course']);
    }

    public function actionStudents()
    {
        $students = Student::find()->all();
        $data = [
          'students' => array_reverse($students)
        ];
        return $this->render("students", $data);
    }

    public function actionRegistration($id)
    {
        $registration = Registration::find()->where(['user_id' => $id])->one();

        if(Yii::$app->request->post('Registration')) {
            $registration->status = Yii::$app->request->post('Registration')['status'];
            $registration->message = Yii::$app->request->post('Registration')['message'];
            $registration->save();
            Yii::$app->session->setFlash('success', "Your response has been sent");
            return $this->redirect(['students']);
        }
        $data = [
            'registration' => $registration
        ];
        return $this->render('registration', $data);
    }

}