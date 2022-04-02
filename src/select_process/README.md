## Make Database Operations Easier
___

### Select Operation Class
In this class you can select data from database with using functions listed below:

##### Select Function - select()
This function needs one compulsory value and three optional value. These are:

- table_name
    - Table which contains data to be received.
- column_name 
    - Column name to be retrieved. Default value: NULL.
- column_value 
    - The value of the column to be received. Default value: NULL.
- limit_value
    - Data limit to be received in total. Default value: NULL.

Returns three parameters:
- fetch
- fetch_json
- count


##### Example code for select function

Let **users** database be like:
| id | name | surname | email | perm |
| - | - | - | - | - |
| 1 | John | Doe | john@doe.com | admin |
| 2 | James | Webb | james@webb.com | user |
| 3 | Rob | Robby | rob@robby.com | user |

###### Specific Line Selection

&emsp; It is also possible to pull certain rows by entering the *column_name* and *column_value*. Also you can limit pulled rows with entering *limit_value*.

In example:

```php
$conn = new Select();

$conn->select("users", "perm", "user", 1);
$data = $conn->fetch;
```

It lists only 1 of the users with "user" privilege.


###### Multiple Line Selection


```php
$conn = new Select();

$conn->select("users");
$data = $conn->fetch;

foreach ($data as $row) {
    echo $row["name"]." ".$row["surname"]."<br>";
}
```
This code returns

    John Doe
    James Webb
    Rob Robby

And, this code prints the data pulled from the database as JSON

```php
$conn = new Select();

$conn->select("users");
echo $conn->fetch_json;
```

Output:

```JSON
[
    {
        "id": 1,
        "name": "John",
        "surname": "Doe",
        "email": "john@doe.com"
    },
    {
        "id": 2,
        "name": "James",
        "surname": "Webb",
        "email": "james@webb.com"
    },
    {
        "id": 3,
        "name": "Rob",
        "surname": "Robby",
        "email": "rob@robby.com"
    }
]
```

And also **count** returns number of lines:

```php
$conn = new Select();

$conn->select("users");
echo $conn->count;
```

This code returns:

    3


##### select_with_two_params()
It is planned to be used in applications such as user login.

This function needs five compulsory values. These are:

- table_name
    - Table which contains data to be received.
- first_column_name 
    - Name of the first column to pull data from.
- second_column_name 
    - Name of the second column to pull data from.
- first_column_value
    - The value of the value sought in the first column from which the data will be drawn.
- second_column_value
    - The value of the value sought in the second column from which the data will be drawn.

Example:

```php
$query = $conn->select_with_two_params("users", "name", "surname", "john", "doe");
if ($query) {
    print_r($conn->fetch);
} else {
    echo "There is no any records!";
}
```

Output:

    true
