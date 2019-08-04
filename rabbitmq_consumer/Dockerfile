FROM python:3
WORKDIR /var/www/rabbitmq_consumer
ENV RABBITMQ_HOST rabbitmq
ENV RABBITMQ_USER rabbitmquser
ENV RABBITMQ_PASSWORD some_password
ENV PYTHONPATH /var/www/rabbitmq_consumer
COPY requirements.txt requirements.txt
RUN pip install -r requirements.txt
COPY . .
CMD ["python", "./consumer.py"]