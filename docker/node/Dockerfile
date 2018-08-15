# FROM node:alpine
FROM node

# RUN apk add --update \
#     ca-certificates openssl && \
#     update-ca-certificates && \
#     apk add  --update --no-cache \
#     curl \
#     libedit libedit-dev \
#     pngquant \
#     icu icu-dev \
#     zlib zlib-dev \
#     g++ \
#     libxml2 libxml2-dev \
#     xz xz-dev xz-libs \
#     ruby \
#     libpng libpng-dev \
#     libsass libsass-dev \
#     sudo \
# && echo 'apk ran okay'

RUN apt update && apt install -y \
    curl \
    g++ \
    libxml2 libxml2-dev \
    libpng-dev \
    libsass-dev sassc \
&& echo 'apt ran okay'
