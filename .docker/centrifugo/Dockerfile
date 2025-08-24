FROM centrifugo/centrifugo:v6 as Base

FROM base AS dev

COPY .docker/centrifugo/config-test.json /centrifugo/config.json

CMD ["centrifugo", "-c",  "config.json"]

FROM base AS prod

COPY .docker/centrifugo/config.json /centrifugo/config.json

CMD ["centrifugo", "-c",  "config.json"]


