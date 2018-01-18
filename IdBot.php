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
    }

}
