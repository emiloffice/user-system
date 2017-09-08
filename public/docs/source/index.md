---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general
<!-- START_5b4a0ea71d9ece2f40ffdfcc4d99b37c -->
## api/v1/test

> Example request:

```bash
curl -X GET "http://localhost/api/v1/test" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/test",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "status": "success",
    "user": "1"
}
```

### HTTP Request
`GET api/v1/test`

`HEAD api/v1/test`


<!-- END_5b4a0ea71d9ece2f40ffdfcc4d99b37c -->

