<?php

declare(strict_types=1);

return [
    "labels" => [
        "search"   => "Поиск",
        "base_url" => "Базовый URL",
    ],

    "auth" => [
        "none"        => "Этот API не требует аутентификации.",
        "instruction" => [
            "query"         => <<<TEXT
                Для аутентификации запросов включите параметр **`:parameterName`** в строку запроса.
                TEXT,
            "body"          => <<<TEXT
                Для аутентификации запросов включите параметр **`:parameterName`** в тело запроса.
                TEXT,
            "query_or_body" => <<<TEXT
                Для аутентификации запросов включите параметр **`:parameterName`** либо в строку запроса, либо в тело запроса.
                TEXT,
            "bearer"        => <<<TEXT
                Для аутентификации запросов включите заголовок **`Authorization`** со значением **`"Bearer :placeholder"`**.
                TEXT,
            "basic"         => <<<TEXT
                Для аутентификации запросов включите заголовок **`Authorization`** в форме **`"Basic {credentials}"`**.
                Значение `{credentials}` должно быть вашим именем пользователя/ID и паролем, соединёнными двоеточием (:),
                и закодированными в base64.
                TEXT,
            "header"        => <<<TEXT
                Для аутентификации запросов включите заголовок **`:parameterName`** со значением **`":placeholder"`**.
                TEXT,
        ],
        "details"     => <<<TEXT
            Все конечные точки, требующие аутентификации, помечены значком `requires authentication` в документации ниже.
            TEXT,
    ],

    "headings" => [
        "introduction" => "Введение",
        "auth"         => "Аутентификация запросов",
    ],

    "endpoint" => [
        "request"          => "Запрос",
        "headers"          => "Заголовки",
        "url_parameters"   => "Параметры URL",
        "body_parameters"  => "Параметры тела",
        "query_parameters" => "Параметры запроса",
        "response"         => "Ответ",
        "response_fields"  => "Поля ответа",
        "example_request"  => "Пример запроса",
        "example_response" => "Пример ответа",
        "responses"        => [
            "binary" => "Бинарные данные",
            "empty"  => "Пустой ответ",
        ],
    ],

    "try_it_out" => [
        "open"              => "Попробовать ⚡",
        "cancel"            => "Отмена 🛑",
        "send"              => "Отправить запрос 💥",
        "loading"           => "⏱ Отправка...",
        "received_response" => "Ответ получен",
        "request_failed"    => "Ошибка запроса",
        "error_help"        => <<<TEXT
            Совет: Проверьте подключение к сети.
            Если вы поддерживаете этот API, убедитесь, что API работает и CORS включён.
            Для отладки можно проверить консоль Dev Tools.
            TEXT,
    ],

    "links" => [
        "postman" => "Посмотреть коллекцию Postman",
        "openapi" => "Посмотреть спецификацию OpenAPI",
    ],
];
