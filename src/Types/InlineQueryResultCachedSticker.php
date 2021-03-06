<?php

namespace Zetgram\Types;

use stdClass;

/*
Represents a link to a sticker stored on the Telegram servers. By default, this sticker will
    be sent by the user. Alternatively, you can use input_message_content to send a message with
    the specified content instead of the sticker.
    Note: This will only work in Telegram versions released after 9 April, 2016 for static
    stickers and after 06 July, 2019 for animated stickers. Older clients will ignore them.

Source: https://core.telegram.org/bots/api#inlinequeryresultcachedsticker
*/
class InlineQueryResultCachedSticker extends InlineQueryResult
{
    /**
    * Type of the result, must be sticker
    * @var string
    */
    public string $type;

    /**
    * Unique identifier for this result, 1-64 bytes
    * @var string
    */
    public string $id;

    /**
    * A valid file identifier of the sticker
    * @var string
    */
    public string $stickerFileId;

    /**
    * Inline keyboard attached to the message
    * @var InlineKeyboardMarkup
    */
    public ?InlineKeyboardMarkup $replyMarkup;

    /**
    * Content of the message to be sent instead of the sticker
    * @var InputMessageContent
    */
    public ?InputMessageContent $inputMessageContent;

    protected function build(stdClass $data)
    {
        $this->type = $data->type;
        $this->id = $data->id;
        $this->stickerFileId = $data->sticker_file_id;
        if (isset($data->reply_markup)) {
            $this->replyMarkup = new InlineKeyboardMarkup($data->reply_markup);
        }
        if (isset($data->input_message_content)) {
            $this->inputMessageContent = new InputMessageContent($data->input_message_content);
        }
    }
}