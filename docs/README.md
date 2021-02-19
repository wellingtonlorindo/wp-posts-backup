# WP Posts Backup API

You can also use Postman and import the api.postman_collection.json file on this directory.

## Headers

You will need an api token and use it in all your requests along with the other headers.
```
Accept: application/json
Content-Type: application/json
Authorization: Bearer {{ your_token_here }}
```

### Getting a list of posts

GET /api/posts?page=1

#### Response

```
HTTP/1.1 200 OK

{
    "status": "success",
    "posts": {
        "current_page": 1,
        "data": [
            {
                "id": 11,
                "post_id": 123,
                "post_title": "My title",
                "post_content": "the content here",
                "created_at": "2021-02-19 02:01:07",
                "updated_at": "2021-02-19 02:01:07"
            },
            {
                "id": 10,
                "post_id": 456,
                "post_title": "My second",
                "post_content": "the content here",
                "created_at": "2021-02-19 01:53:19",
                "updated_at": "2021-02-19 01:53:19"
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/posts?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://127.0.0.1:8000/api/posts?page=1",
        "next_page_url": null,
        "path": "http://127.0.0.1:8000/api/posts",
        "per_page": 20,
        "prev_page_url": null,
        "to": 8,
        "total": 8
    }
}
```

### Getting a single post

GET /api/posts/{id}

#### Response

```
HTTP/1.1 200 OK

{
    "status": "success",
    "post": {
        "id": 8,
        "post_id": 456,
        "post_title": "My second",
        "post_content": "the content here",
        "created_at": "2021-02-19 01:53:19",
        "updated_at": "2021-02-19 01:53:19"
    }
}
```

### Adding a list of posts

You can add/edit a list of posts at once.

POST /api/posts

#### Body

```
[
    {
        "post_id": 123,
        "post_title": "My first",
        "post_content": "the content here"
    },
    {
        "post_id": 456,
        "post_title": "My second",
        "post_content": "the content here"
    }
]
```

#### Response

```
HTTP/1.1 200 OK

{
    "status": "success",
    "message": "Post saved",
    "posts": [
        {
            "id": 9,
            "post_id": 123,
            "post_title": "My first",
            "post_content": "the content here",
            "created_at": "2021-02-19 01:53:19",
            "updated_at": "2021-02-19 01:53:38"
        },
        {
            "id": 10,
            "post_id": 456,
            "post_title": "My second",
            "post_content": "the content here",
            "created_at": "2021-02-19 01:53:19",
            "updated_at": "2021-02-19 01:53:19"
        }
    ]
}
```

### Adding a single post

POST /api/posts

#### Body

```
{
    "post_id": 123,
    "post_title": "My first",
    "post_content": "the content here"
}
```

#### Response

```
HTTP/1.1 200 OK

{
    "status": "success",
    "message": "Post saved",
    "posts": [
        {
            "post_id": 123,
            "post_title": "My title",
            "post_content": "the content here",
            "updated_at": "2021-02-19 02:01:07",
            "created_at": "2021-02-19 02:01:07",
            "id": 11
        }
    ]
}
```

### Editing a post

PATCH /api/posts/{id}

#### Body

```
{
    "post_id": 123,
    "post_title": "My title have changed",
    "post_content": "the content here"
}
```

#### Response

```
HTTP/1.1 200 OK

{
    "status": "success",
    "message": "Post updated",
    "post": {
        "id": 9,
        "post_id": 123,
        "post_title": "My title have changed",
        "post_content": "the content here",
        "created_at": "2021-02-19 01:53:19",
        "updated_at": "2021-02-19 01:56:28"
    }
}
```

### Deleting a post

DELETE /api/posts/{id}

#### Response

```
HTTP/1.1 200 OK

{
    "status": "success"
}
```