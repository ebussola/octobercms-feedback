October CMS Feedback Plugin
===========================

This plugin intended to solve the miss of communication between you and your website's visitor.
From the simple contact form to a complex feedback about a product that you are selling.
It uses configurable channels to specify how and which method you want to receive the messages.

## Installation

Simple search for eBussola.Feedback and install it.

The basic component template uses a javascript alert to show response messages from the backend.
It is quite ugly, but for who don't know how to code, it is a good start.

However, the messages are stored on the *Flash Bag* too, so you can use the it to display messages.
See https://octobercms.com/docs/markup/tag-flash

## Using

Feedback uses Channels to communicate with you, you choose the best one for your needs and configure it.

By default, and for convenience, it will also save the messages on the DB too. (you can disable it)

After the installation, go to Settings > Channels (under Feedback's section).
You will notice that you already have one Channel configured. It is the basic Channel that uses the Email and DB,
sending for your Admin's email.
Reconfigure as you want or create another one.

Once configured, go to your page editor (Menu CMS) and add the Feedback Component.

Of course all snippets can be customized, they are used just to faster the development and to be used as a guide.

### Channels

Channels are the way and how you want to receive the messages.

Each Channel uses a set of configuration. Of course it depends on the Channel you want to use.

Feedback comes with 1 Channel, the Email Channel.

### Working with messages

On the Feedback menu option you can list all your messages.
You can archive your "done" messages by selecting and clicking on "Archive".
Or just open the message and click "Archive"

You can list all your archived messages too.

If you have more than one Channel, you can filter the messages on the filter based on the top of the list, just before 
the list headers.

## Extending

_This section is for developers only_

If you want to develop a Method to use with Feedback's Channel, you need to create a Class and implement the
Method interface (\Ebussola\Feedback\Classes\Method).

Basically you have to add field(s) to Channel's form and customise the Channel model depending on how your Method works.
And of course, develop the behavior of your Method.

You can read more about how to extend forms and models on October's documentation.

Extending form behavior: https://octobercms.com/docs/backend/forms#extend-form-behavior

Extending models: https://octobercms.com/docs/database/model#extending-models