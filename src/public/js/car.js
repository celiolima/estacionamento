
  $(document).ready(function(){
    // Get Report passenger
    $(document).on('click', '#car_filter', function(){
      
      var date_sel_start = $('#date_sel_start').val();
      var date_sel_end = $('#date_sel_end').val();     
      var time_sel_start = $('#time_sel_start').val();
      var time_sel_end = $('#time_sel_end').val();   
      
      $.ajax({
        url: '/car',
        type: 'POST',
        data: {      
          'date_sel_start': date_sel_start,
          'date_sel_end': date_sel_end,         
          'time_sel_start': time_sel_start,
          'time_sel_end': time_sel_end,         
        } ,
        success: function (results) { 
          let car = results.results
          $('#containe').empty()
          for (let i = 0; i < car.length; i++) {        

           $(
              `
                <div id="image-viewer">
                  <span class="close">&times;</span>
                  <img class="modal-content" id="full-image">
                </div>
                <div class="images col-6 col-lg-2">
                  <img class="img-fluid " style="width: 100%;height: auto;"src="${car[0].name}" alt="My Image" />
                </div>
                
              `              
              ).appendTo('#containe');
            
            console.log(car[0].name) 
          }              
         
        }
      })
    
    });

    <% results.forEach((car)=>{%>
      $(`
        <div id="image-viewer">
          <span class="close">&times;</span>
          <img class="modal-content" id="full-image">
        </div>
        <div class="images col-6 col-lg-2">
          <img class="img-fluid " style="width: 100%;height: auto;"src="<%=car.name%>" alt="My Image" />
        </div>
        
      `).appendTo('#containe');
    <%})%>


      $(".images img").click(function(){
      $("#full-image").attr("src", $(this).attr("src"));
      $('#image-viewer').show();
      });

      $("#image-viewer .close").click(function(){
        $('#image-viewer').hide();
      });

  });

 