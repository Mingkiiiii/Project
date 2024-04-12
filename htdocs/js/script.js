function href(url) {
  document.location.href = url;
}

function frmSubmit(frm, url, msg, move) {
  $.ajax({
    type: "POST",
    url: url,
    data: $(frm).serialize(),
    success: function(result) {
      if (result) {
        alert(result);
      } else {
        alert(msg);
        document.location.replace(move);
      }
    }
  })

  return false;
}