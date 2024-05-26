let breweriesManager = {

  dataTable: null,

  init:function(){
    breweriesManager.loadData();
  },

  loadData: function(){
    $('#col_breweries-table').block()
    $.ajax({
      type: 'GET',
      url: routeGetBreweriesList,
      success: function (result, status, xhr) {
        if(result.success){
          let tableBody = '';
          for (let i = 0, l = result.data.length; i < l; i++) {
            tableBody += '<tr>' +
                         '<td>' + securityManager.preventXSSAttacks(result.data[i].id) + '</td>' +
                         '<td>' + securityManager.preventXSSAttacks(result.data[i].name) + '</td>' +
                         '<td>' + securityManager.preventXSSAttacks(result.data[i].brewery_type) + '</td>' +
                         '<td>' + securityManager.preventXSSAttacks(result.data[i].city) + '</td>' +
                         '<td>' + securityManager.preventXSSAttacks(result.data[i].country) + '</td>' +
                         '<td>' + securityManager.preventXSSAttacks(result.data[i].phone) + '</td>' +
                         '</tr>';
          }
          $('#breweries-table_body').append(tableBody);
          breweriesManager.dataTable = $('#breweries-table').DataTable({
            order: [1, 'desc'],
          });
        }else{
          toastr.error(result.message, 'Operation failed!');
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(errorThrown, 'Operation failed!');
      },
      complete:function(){
        $('#col_breweries-table').unblock();
      },
    });
  },

}
