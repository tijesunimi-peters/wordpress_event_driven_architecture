import pika
import os
import json
import datetime

URL = "amqp://%s:%s@%s:%s/?heartbeat=60" % (os.environ['RABBITMQ_USER'], os.environ['RABBITMQ_PASSWORD'], os.environ['RABBITMQ_HOST'], '5672')

connection = pika.BlockingConnection(pika.URLParameters(URL))
channel = connection.channel()

channel.queue_declare(queue='ibl_analytics_event')

def callback(ch, method, properties, body):
    print(" [x] Received %s" % json.loads(body.decode()))

    connection2 = pika.BlockingConnection(pika.URLParameters(URL))
    channel2 = connection2.channel()

    parsed_body = json.loads(body.decode())

    transformed = { "transformed_body": parsed_body, "created_at": str(datetime.datetime.now()) }
    stringified = json.dumps(transformed)

    print(' [*] Storing event in store *****************************')
    channel2.queue_declare(queue='ibl_analytics_event_store')

    channel2.basic_publish(exchange='',routing_key='ibl_analytics_event_store',body=stringified)

    connection2.close()


channel.basic_consume(queue='ibl_analytics_event',
                      auto_ack=True,
                      on_message_callback=callback)

print(' [*] Waiting for messages. To exit press CTRL+C')
channel.start_consuming()