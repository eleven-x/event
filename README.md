# Eleven-x Event 

Simple php event system

## Install 

`composer require eleven-x/event`

## API



###  addListener($eventName, \Closure $listener, $priority = 0, $once = false)

Adds the listener function to the end of the listeners array for the event named `$eventName`

- `$eventName` <string>   event name
- `$listener` <Closure> listener function
- `$priority` <int>   The higher the value, the higher the priority
- `$once`  <boolean> whether it is a one-time



###  once($eventName, \Closure $listener)

Adds a one time listener function for the event named `$eventName`. 
The next time `$eventName` is triggered, this listener is removed and then invoked.

- `$eventName` <string>   event name
- `$listener` <Closure> listener function


###  removeListener($eventName)

Removes the specified listener from the listener array for the event named `$eventName`.

- `$eventName` <string>   event name


###  hasListeners($eventName)
 Whether there is a listener

- `$eventName` <string>   event name




###  dispatch($eventName, Event $event = null)  
Calls each of the listeners registered for the event named `$eventName`

- `$eventName` <string>   event name
-  `$event`   <Event>  Event object

## License

MIT