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
    $(function () {
        $('#addMore').on('click', function () {
            var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
            data.find("input").val('');
        });
        $(document).on('click', '.remove', function () {
            var trIndex = $(this).closest("tr").index();
            if (trIndex > 1) {
                $(this).closest("tr").remove();
            } else {
                alert("Sorry!! Can't remove first row!");
            }
        });
    });
</script>