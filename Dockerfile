FROM ruby:3.0.3

ENV TZ Asia/Tokyo
ENV LANG C.UTF-8

ENV RAILS_ENV=production

WORKDIR /app
COPY ./src /app
RUN bundle install

COPY startup.sh /startup.sh
RUN chmod 744 /startup.sh
CMD [ "sh", "/startup.sh" ]
