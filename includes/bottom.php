    <div id="about">
            
        </div>

</div>

        <script>
            $(document).ready(function () {
                
                //dynamically load the dialog data
                $.ajax({
                    url: 'get_about.php',
                    method: 'POST',
                    data: {},
                    success: function(data)
                    {
                        $("#about").html(data);
                    }
                })

                $("#about").dialog({
                    title: "About SMART RETIAL",
                    draggable: false,
                    resizable: false,
                    modal: true,
                    width: 500,
                    closeOnEscape: true,
                    autoOpen: false,
                    buttons: [
                        {
                            text: "Close",
                            click: function(){
                                $(this).dialog("close");
                            }
                        }
                    ]
                });
                
                $("#about_btn").click(function(){
                    $("#about").dialog("open");
                });


            });

        </script>
        <script>
            //activate my js plugins here.
            wow = new WOW(
            {
              animateClass: 'animated',
                        offset: 100,
                        callback: function (box) {
                            console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
                        }
                    }
                );
                wow.init();

                //Initialise select2
                $(".select2").select2();
                
                //initialise jquery preimage
                $('.file').preimage();
        </script>
        
        <script>
            $(".datepicker").datepicker({
                dateFormat: "dd/mm/yy",
                changeYear: true, changeMonth:true
            });
        </script>

    </body>
</html>