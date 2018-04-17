 <ul id="wrapper">
    <li><a href="#">Projects <span class="number">3</span> </a></li>
    <li><a href="#">Music <span class="number">4</span> </a></li>
    <li><a href="#">Photos <span class="number">2</span> </a></li>
</ul>

@import url(https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700);

*           {       margin:0;
                    padding:0;
                    list-style: none;
                    text-decoration: none;}

body        {       background:#333;}


#wrapper    {       width:400px;
                    margin:50px auto 0 auto;
                    border-radius:20px;
                    overflow:hidden;
                    background:#222;
                    border:1px solid #00c6ff;
                    border: inset 1px #555;}
                    
.number     {       padding: 0 50px 0 0;
                    float:right;}
                    
a.selected 
            {       background:#00c6ff;
                    color:#333;}
                         
li          {       
                    
                    font-family:'Roboto Condensed', Arial, Helvetica, sans-serif;
                    font-size:20px;
  
                    
                    color:#00c6ff;}
                    
                    
li a        {       color:#00c6ff;
                    padding:20px;
                    width:100%;
                    display: block;
                    background-image: linear-gradient(to left,
                                      transparent,
                                      transparent 50%,
                                      #00c6ff 50%,
                                      #00c6ff);
                   background-position: 100% 0;
    background-size: 200% 100%;
    transition: all .25s ease-in;
    
                    
}

li a:hover {        background-position: 0 0;
                    color:#333;
}


<link  rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<table  class="table table-hover small-text" id="tb">
<tr class="tr-header">
<th>Full Name</th>
<th>Designation</th>
<th>Mobile No.</th>
<th>Email Id</th>
<th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Person"><span class="glyphicon glyphicon-plus"></span></a></th>
<tr>
<td><input type="text" name="fullname[]" class="form-control"></td>
<td><select name="designation[]" class="form-control">
  <option value="" selected>Select Designation</option>
    <option value="Engineer">Engineer</option>
    <option value="Accountant">Accountant</option>
</select></td>
<td><input type="text" name="mobileno[]" class="form-control"></td>
<td><input type="text" name="emailid[]" class="form-control"></td>
<td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a></td>
</tr>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> 
<script>
$(function(){
    $('#addMore').on('click', function() {
              var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
              data.find("input").val('');
     });
     $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>1) {
             $(this).closest("tr").remove();
           } else {
             alert("Sorry!! Can't remove first row!");
           }
      });
});      
</script>