<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mail`.
 */
class m170708_075627_create_mail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%mail}}', [
            'id' => $this->primaryKey()->comment('#'),
            'email' => $this->string(255)->comment('Email'),
            'theme' => $this->string(255)->comment('Тема'),
            'text' => $this->text()->comment('Сообщение'),
            'created_at' => $this->datetime()->comment('Время создания'),
        ]);

        $data = [
            [
                'email' => 'test1@test.test',
                'theme' => 'test1',
                'text' => 'test1 mail text',
            ],
            [
                'email' => 'test2@test.test',
                'theme' => 'test2',
                'text' => 'test2 mail text',
            ],
            [
                'email' => 'test3@test.test',
                'theme' => 'test3',
                'text' => 'test3 mail text',
            ],
            [
                'email' => 'test4@test.test',
                'theme' => 'test4',
                'text' => 'test4 mail text',
            ],
            [
                'email' => 'test5@test.test',
                'theme' => 'test5',
                'text' => 'test5 mail text',
            ],
            [
                'email' => 'test6@test.test',
                'theme' => 'test6',
                'text' => 'test6 mail text',
            ],
        ];

        for ($i = 0; $i < count($data); $i++) {
            $this->insert('{{%mail}}', [
                'email' => $data[$i]['email'],
                'theme' => $data[$i]['theme'],
                'text' => $data[$i]['text'],
                'created_at' => new \yii\db\Expression('NOW()')
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%mail}}');
    }
}
