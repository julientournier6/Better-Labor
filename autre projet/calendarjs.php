<?php
  session_start();
  if(isset($_SESSION['admin']) AND $_SESSION['admin'] == 1) {
    $admin = 1;
  }
  else {
    $admin = 0;
  }
?>
<script type="text/javascript">
        var admin = '<?php echo $admin ?>'; 
var cal = {
  hMth:null, hYr:null,
  hWrap:null,
  hBlock:null, hForm:null, hFormDel:null, hFormCX:null,
  hID:null, hStart:null, hEnd:null, hTxt:null, hColor:null, hOrganizers:null,
  init : () => {
    cal.hMth = document.getElementById("calmonth");
    cal.hYr = document.getElementById("calyear");
    cal.hWrap = document.getElementById("calwrap");
    cal.hBlock = document.getElementById("calblock");
    cal.hForm = document.getElementById("calform");
    cal.hFormDel = document.getElementById("calformdel");
    cal.hFormCX = document.getElementById("calformcx");
    cal.hID = document.getElementById("evtid");
    cal.hStart = document.getElementById("evtstart");
    cal.hEnd = document.getElementById("evtend");
    cal.hTxt = document.getElementById("evttxt");
    cal.hColor = document.getElementById("evtcolor");
    cal.hOrganizers = document.getElementById("evtorganizers");

    cal.hMth.onchange = cal.draw;
    cal.hYr.onchange = cal.draw;
    cal.hForm.onsubmit = cal.save;
    cal.hFormDel.onclick = cal.del;
    cal.hFormCX.onclick = cal.hide;

    cal.draw();
  },

  ajax : (data, load) => {
    fetch("calendarajax.php", { method:"POST", body:data })
    .then(res=>res.text()).then(load);
  },

  draw : () => {
    let data = new FormData();
    data.append("req", "draw");
    data.append("month", cal.hMth.value);
    data.append("year", cal.hYr.value);
    cal.ajax(data, (res) => {
      cal.hWrap.innerHTML = res;

      if (admin == 1) {
      for (let day of cal.hWrap.getElementsByClassName("day")) {
        day.onclick = () => { cal.show(day); };
      }

      for (let evt of cal.hWrap.getElementsByClassName("calevt")) {
        evt.onclick = (e) => { cal.show(evt); e.stopPropagation(); };
      }
    }
      });
  },

  show : (cell) => {
    let eid = cell.getAttribute("data-eid");

    if (eid === null) {
      let y = cal.hYr.value, m = cal.hMth.value, d = cell.dataset.day;
      if (m.length==1) { m = "0" + m; }
      if (d.length==1) { d = "0" + d; }
      let ymd = `${y}-${m}-${d}T00:00:00`; // RFC 3339
      cal.hForm.reset();
      cal.hID.value = "";
      cal.hStart.value = ymd;
      cal.hEnd.value = ymd;
      cal.hFormDel.style.display = "none";
    }

    else {
      let edata = JSON.parse(document.getElementById("evt"+eid).innerHTML);
      cal.hID.value = eid;
      cal.hStart.value = edata["start"].replaceAll(" ", "T");
      cal.hEnd.value = edata["end"].replaceAll(" ", "T");
      cal.hTxt.value = edata["text"];
      cal.hColor.value = edata["color"];
      cal.hOrganizers.value = edata["organizers"];
      cal.hFormDel.style.display = "block";
    }

    cal.hBlock.classList.add("show");
  },

  hide : () => { cal.hBlock.classList.remove("show"); },

  save : () => {
    cal.ajax(new FormData(cal.hForm), (res) => {
      if (res=="OK") { cal.hide(); cal.draw(); }
      else { alert(res); }
    });
    return false;
  },

  del : () => { if (confirm("Delete Event?")) {
    let data = new FormData();
    data.append("req", "del");
    data.append("eid", cal.hID.value);

    cal.ajax(data, (res) => {
      if (res=="OK") { cal.hide(); cal.draw(); }
      else { alert(res); }
    });
  }}
};
window.addEventListener("DOMContentLoaded", cal.init);
</script>