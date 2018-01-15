## Web Examples for Event Service
Simple web examples on requesting and displaying events from the Event Service.

### Run
```bash
open index.html in a browser
```

### Roadmap

index.html represents the original concept, supporting a variety of options

However, this posed a few problems when deployed on the site. Perhaps the most significant was that $.formatDateTime would not be defined when deployed. Another issue had to do with style conflicts between here and the pages this would be deployed on.

lite.html represents the first "quick fix" for these issues - a minimalistic implementation which worked where it needed to work

example.html shows how this would be deployed (search for "cut here" in the html to see the part that gets deployed).

medium.html represents a second pass at trying to make the original concept available, though the $.formatDateTime issue still killed it.

refresh.html shows a second pass at the "lite" concept. Here, the door status on the page gets updated (though we shut that down if the user walks away from their machine - no point spamming the system when someone leaves the page up while they go to work or to sleep).
    
### License

Apache License, Version 2.0
