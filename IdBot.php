<?php

class IdBot extends \Prowebcraft\Telebot\Telebot
{

    /**
     * Gets group or user id (depending on context)
     */
    public function idCommand()
    {
        if ($this->isChatPrivate()) {
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

}
