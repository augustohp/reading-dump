<?php

function pocketAdd(Pocket $api, $url, $title, array $tags)
{
    return $api->add([
        "url" => $url,
        "title" => $title,
        "tags" => implode(',', $tags)
    ]);
}

function pocketSearch(Pocket $api, array $options)
{
    return $api->retrieve($options);
}

function pocketTag(Pocket $api, $articleId, array $tags)
{
    return $api->send([
        [
            "item_id" => $articleId,
            "action" => "tags_add",
            "tags" => implode(',', $tags)
        ]
    ]);
}
