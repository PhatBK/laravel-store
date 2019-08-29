<?php

use Illuminate\Database\Seeder;
use App\User;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // seeder tasks
        $count_users = User::count();

        $lorem = 'lorem ipsum, quia dolor sit amet consectetur adipiscing velit, sed quia non-numquam do eius modi tempora incididunt, ut labore et dolore magnam aliquam quaerat voluptatem.';

        for ( $i = 1; $i < 25; $i++ ) {

            $master = rand(2, $count_users-1);
            $slave  = rand($master, $count_users-1);
            $title = 'Title test task #' . $i;

            DB::table('tasks')->insert([
                'master_user_id' => $master,
                'slave_user_id' => $slave,
                'title' => $title,
                'slug' => Str::slug($title, '-'),
                'description' => 'Description for task #' . $i . '. ' . $lorem ,
                'tasksstatus_id' => rand(1, 5),
                'taskspriority_id' => rand(1, 4),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // task for owner
        $arr_task_for_owner = [
            [
                'title' => 'Исправить валидацию в контроллерах',
                'description' => 'Добавить required_with, exists, unique:table,column,except,idColumn, sometimes и прочее. </p><p> http://laravel.su/docs/5.0/validation#controller-validation </p><p> http://laravel.su/docs/5.4/Validation#available-validation-rules.',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            [
                'title' => 'Учесть субординацию в постановке задач',
                'description' => 'Учесть субординацию в постановке задач.',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            [
                'title' => 'продумать модальную форму',
                'description' => 'public_html/resources/views/includes/modalForm.blade.php.',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            [
                'title' => 'Заменить Status на OrderStatus',
                'description' => 'Заменить Status на OrderStatus, StatusesTableSeeder на OrderStatusesTableSeeder, CreateStatusesTable на CreateOrderStatusesTable, etc.',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            [
                'title' => 'Изменить обновление записи',
                'description' => 'Делать изменение записи только при изменении.',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            [
                'title' => 'Свернуть меню админки',
                'description' => 'Слишком длинное меню получается. </p><p> Свернуть подпункты как подкатегории в меню каталога.',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            [
                'title' => 'Уникальность наименования товара',
                'description' => 'Разобраться, нужна-ли. Если да, то добавить валидацию в контроллер.',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            [
                'title' => 'Добавить возможность вставки таблиц',
                'description' => 'Добавить возможность вставки таблиц. Вставка исходного html-кода с последующей чисткой на стороне сервера.',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            [
                'title' => 'Доработать TaskList',
                'description' => '
                Добавить отображение задач и поручений в виде карточек.
                </p><p>Добавить историю.
                </p><p>Добавить копирование.
                ',
                'tasksstatus_id' => 1,
                'taskspriority_id' => 1,
            ],

            // [
            //     'title' => 'rrrrrr',
            //     'description' => 'rrrrrrr.',
            //     'tasksstatus_id' => 1,
            //     'taskspriority_id' => 1,
            // ],

            // [
            //     'title' => 'rrrrrr',
            //     'description' => 'rrrrrrr.',
            //     'tasksstatus_id' => 1,
            //     'taskspriority_id' => 1,
            // ],

            // [
            //     'title' => 'rrrrrr',
            //     'description' => 'rrrrrrr.',
            //     'tasksstatus_id' => 1,
            //     'taskspriority_id' => 1,
            // ],

        ];

// (`master_user_id`, `slave_user_id`, `title`, `slug`, `description`, `tasksstatus_id`, `taskspriority_id`, `created_at`, `updated_at`) values 
// (2,  2,   Изменить обновление записи, title-test-task-4, Делать изменение записи только при изменении., opened, 1, 2019-08-28 16:45:26, 2019-08-28 16:45:26)


        foreach ( $arr_task_for_owner as $i => $task ) {

            DB::table('tasks')->insert([
                'master_user_id' => 2,
                'slave_user_id' => 2,
                'title' => $task['title'] ?? Str::limit($task->description, 20),
                'slug' => Str::slug($task['title'], '-'),
                'description' => $task['description'],
                'tasksstatus_id' => $task['tasksstatus_id'],
                'taskspriority_id' => $task['taskspriority_id'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
