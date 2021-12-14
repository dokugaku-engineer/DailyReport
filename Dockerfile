FROM ruby:3.0.3

ENV TZ Asia/Tokyo
ENV LANG C.UTF-8

WORKDIR /app

COPY ./src /app

RUN bundle config --local set path 'vendor/bundle' \
  && bundle install

CMD ["/bin/sh"]