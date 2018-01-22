<?php

use TelegramBot\Api\Types\Inline\InputMessageContent\Text;
use TelegramBot\Api\Types\Inline\QueryResult\Article;

class IdBot extends \Prowebcraft\Telebot\Telebot
{

    /**
     * Gets group or user id (depending on context)
     */
    public function idCommand()
    {
        if ($this->isChatGroup()) {
            $this->groupIdCommand();
        } else {
            $this->myIdCommand();
        }
    }

    /**
     * Gets user id
     */
    public function myIdCommand()
    {
        $this->replyToLastMessageWithMarkdown('You id is: *' . $this->getUserId() .'*');
    }

    /**
     * Gets group chat id
     */
    public function groupIdCommand()
    {
        if (!$this->isChatGroup()) {
            $this->reply('This is not a group');
        } else {
            $this->replyToLastMessageWithMarkdown('Group id is : *' . $this->getChatId() .'*');
        }
    }

    /**
     * Testing of dialogs
     * @admin
     */
    public function dialogCommand()
    {
        $this->ask('Choose your pill', ['🔴 red', '🔵 blue'], 'dialogResponse');
    }

    /**
     * Testing simple questions
     * @admin
     */
    public function answerCommand()
    {
        $this->ask('Your name?', null, 'answerResponse');
    }

    /**
     * Test inline buttons
     * @admin
     */
    public function inlineCommand()
    {
        $menu = [];
        $menu[] = [
            [
                'text' => "Option one",
                'callback_data' => 'Option one data'
            ]
        ];
        $menu[] = [
            [
                'text' => 'Option two',
                'callback_data' => 'Option two data'
            ],
        ];
        $this->askInline('Use inline buttons?', $menu, 'inlineResponse');
    }

    protected function inlineResponse(\Prowebcraft\Telebot\AnswerInline $answer) {
        $this->replyToLastMessageWithMarkdown("*Your select*: " . $answer->getData());
        $answer->reply(); //Hide waiting message;
    }
    protected function dialogResponse(\Prowebcraft\Telebot\Answer $answer) {
        switch ($answer->getAnswerVariant()) {
            default:
                $this->replyToLastMessageWithMarkdown("*You selected*: " . $answer->getAnswerVariant());
        }
    }

    protected function answerResponse(\Prowebcraft\Telebot\Answer $answer)
    {
        $this->replyToLastMessageWithMarkdown("*You say*: " . $answer->getReplyText());
    }

    protected function handleInlineQuery(\TelegramBot\Api\Types\Inline\InlineQuery $inlineQuery)
    {
        if ($this->isChatGroup()) {
            $id = $this->getChatId();
            return [
                new Article((string)md5($id), "Send group id to chat", 'Group Id: ' . $id, null, null, null,
                    new Text('Group id is : *' . $this->getChatId() .'*', 'markdown', true)
                )
            ];
        } else {
            System_Daemon::debug('Not a group chat');
        }
        return false;
    }

}
