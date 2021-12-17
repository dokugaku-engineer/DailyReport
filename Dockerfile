FROM ruby:3.0.3

ENV TZ Asia/Tokyo
ENV LANG C.UTF-8

WORKDIR /app

COPY ./src /app

RUN bundle install

CMD ["rails", "server", "-b", "0.0.0.0"]
