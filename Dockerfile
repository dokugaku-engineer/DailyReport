FROM ruby:2.7
WORKDIR /myapp
COPY ./src /myapp
RUN bundle install

CMD ["rails", "server", "-b", "0.0.0.0"]
