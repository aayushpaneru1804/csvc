<html>
<head>
<meta charset="UTF-8">
<title>Query Page</title>
<link rel="stylesheet" href="style.css">
</head>


<body class="bodyStyle">
	

	<div id="header" class="mainHeader">
		<hr>
		<div class="center"><h1>Example Social Research Organization</h1></div>
	</div>
	<br>
		<hr>
		<div class="center"><h2>Country Data Query Page</h2></div>
	</div>
	<br>
		<h2><a href="index.php">Home</a></h2>
		
	</div>
	
	<h2>Please select which query you want to run.</h2>
	<form id="form1" method="post" action='query2.php'>
	<select name="selection">
	 <option value="">Select...</option>     
     <option value='Q1'>Mobile phones</option>  
     <option value='Q2'>Population</option>
     <option value='Q3'>Life Expectancy</option>
     <option value='Q4'>GDP</option>
     <option value='Q5'>Childhood Mortality</option>
     
   </select>
   
   <input type="submit" value="Submit">
   </form>
 
<br>
<div id="Copyright" class="center">
    <h5>&copy; 2020, Amazon Web Services, Inc. or its Affiliates. All rights
        reserved.</h5>
</div>

</body>
</html>