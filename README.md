### API для работы с заявками


#### endpoints:
____________________________________________________________________________________________

##### Для получения всех заявок
'GET message' 
____________________________________________________________________________________________

##### Для получения всех заявок с сортировкой по дате создания (asc, desc)
'GET message?sort=<sort>'
____________________________________________________________________________________________

##### Для получения всех заявок пользователя по id пользователя
'GET message/user/<id>'
____________________________________________________________________________________________

##### Для получения всех заявок пользователя по имени ползователя
'GET message/username/<name>' 
____________________________________________________________________________________________

##### Для получения всех заявок по статусу (0 - Resolved, 1 - Active)
'GET message/<status>'
____________________________________________________________________________________________

##### Для получения всех заявок по статусу с сортировкой (0 - Resolved, 1 - Active) (asc, desc)
'GET message/<status>/<sort>'
____________________________________________________________________________________________

##### Для отправки заявки
'POST message' => 'message/post'  
Тело запроса(пример):  
{  
&emsp;&emsp;"comment": "new comment", (обязательное поле)  
&emsp;&emsp;"name": "newUser_555", (обязательное поле)  
&emsp;&emsp;"email": "rrrrrr@mail.ru" (обязательное поле + должно совпадать с email пользователя)  
}  
Если пользователь существует, то отправится заявка от его имени
____________________________________________________________________________________________