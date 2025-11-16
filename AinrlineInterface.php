<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>سیستم رزرو پرواز — رابط کاربری</title>
  <style>
    /* Reset & base */
    :root{
      --primary:#1ba1e2;
      --dark:#1d3557;
      --muted:#6c7a89;
      --card:#ffffff;
      --bg:#f4f7fb;
      --radius:12px;
      --glass: rgba(255,255,255,0.7);
      font-family: "Segoe UI", Roboto, Tahoma, sans-serif;
    }
    *{box-sizing:border-box}
    html,body{height:100%;margin:0;background :var(--bg);color:var(--dark);-webkit-font-smoothing : antialiased  }
    .container{max-width:1100px;margin:28px auto;padding:20px}
    header{display:flex;gap:16px;align-items:center;justify-content:space-between;margin-bottom:18px}
    .brand{display:flex;align-items:center;gap:12px}
    
    .logo{width:56px;height:56px;border-radius:10px;background:linear-gradient(135deg,var(--primary),#78c4f0);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:18px}
    h1{margin:0;font-size:20px}
    .card{background:var(--card);border-radius:var(--radius);box-shadow:0 6px 18px rgba(20,30,60,0.06);padding:18px}
    /* Search form */
    .search{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;align-items:end}
    label{font-size:13px;color:var(--muted);display:block;margin-bottom:6px}
    input,select,button{width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e3e9ef;background:#fff;font-size:14px}
    button.primary{background:var(--primary);color:#fff;border:none;cursor:pointer;padding:12px 14px;border-radius:10px}
    /* results */
    .results{margin-top:18px;display:flex;flex-direction:column;gap:12px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px 12px;border-bottom:1px solid #eef3f7;text-align:right;font-size:14px}
    th{background:#f7fbff;color:var(--dark);font-weight:600}
    .actions button{margin-left:8px;padding:8px 10px;border-radius:8px;border:1px solid #d7e9f6;background:#fff;cursor:pointer}
    .actions button.book{background:linear-gradient(90deg,var(--primary),#4db3e8);color:#fff;border:none}
    /* seat map */
    .seatmap{display:grid;grid-template-columns:repeat(6,1fr);gap:6px;justify-items:center;padding:12px;background:linear-gradient(180deg,#fff,#fbfeff);border-radius:10px}
    .seat{width:40px;height:40px;border-radius:6px;border:1px solid #d8eaf6;display:flex;align-items:center;justify-content:center;cursor:pointer}
    .seat.selected{background:var(--primary);color:#fff;border:none}
    .seat.taken{background:#f5d6d6;color:#9b2d2d;cursor:not-allowed}
    /* responsive */
    @media (max-width:900px){
      .search{grid-template-columns:repeat(2,1fr)}
      .brand h1{font-size:16px}
    }
    @media (max-width:520px){
      .search{grid-template-columns:1fr}
      th,td{font-size:13px}
      .seat{width:34px;height:34px}
    }
    footer{margin-top:18px;text-align:center;color:var(--muted);font-size:13px}
  </style>
</head>
<body>
   <img src="image.jpg" alt="" height="600px" width="1300px"><br><br><br><br><br><br><br><br><br>
  
  <div class="container">
    <header>
      <div class="brand">
        <div class="logo">ARS</div>
        <div>
          <h1>ثبت یا رزرو بلیط — Airline Reservation</h1>
          <div style="font-size:12px;color:var(--muted)">نمایش نمونهٔ رابط برای دیاگرام ER شما</div>
        </div>
      </div>
      <div>
        <button class="primary" onclick="openLogin()">ورود مدیریت</button>
      </div>
    </header>

    <!-- SEARCH CARD -->
    <section class="card">
      <form id="searchForm" class="search" onsubmit="event.preventDefault();searchFlights()">
        <div>
          <label for="from">مبدا (Airport)</label>
          <select id="from"><option value="">-- انتخاب کنید --</option><option value="KBL">Kabul (KBL)</option><option value="DXB">Dubai (DXB)</option></select>
        </div>
        <div>
          <label for="to">مقصد (Airport)</label>
          <select id="to"><option value="">-- انتخاب کنید --</option><option value="KBL">Kabul (KBL)</option><option value="DXB">Dubai (DXB)</option></select>
        </div>
        <div>
          <label for="date">تاریخ رفت</label>
          <input id="date" type="date" />
        </div>
        <div>
          <label>&nbsp;</label>
          <button class="primary" type="submit">جستجوی پروازها</button>
        </div>
      </form>

      <div class="results" id="results">
        <!-- نتایج جستجو اینجا اضافه میشود -->
        <div style="text-align:center;color:var(--muted);padding:18px">نتیجهای نمایش داده نشده — روی «جستجوی پروازها» کلیک کنید.</div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer>
      © 
    </footer>
  </div>

  <script>
    // نمونه دادهٔ شبیهسازیشده (در عمل از API بکاند فراخوانی میکنیم)
    const sampleFlights = [
      {id:'FL1001', airline:'Safir Air', depart:'KBL', arrive:'DXB', depart_time:'2025-11-12 09:00', arrive_time:'2025-11-12 12:00', fare:250},
      {id:'FL1023', airline:'SkyLines', depart:'KBL', arrive:'DXB', depart_time:'2025-11-12 15:00', arrive_time:'2025-11-12 18:00', fare:220},
    ];

    function searchFlights(){
      const resultsEl = document.getElementById('results');
      resultsEl.innerHTML = '';
      // در پروژه واقعی: fetch('/api/flights?from=..&to=..')...
      const table = document.createElement('table');
      table.innerHTML = `
        <thead><tr><th>پرواز</th><th>شرکت</th><th>مبدا</th><th>مقصد</th><th>حرکت</th><th>رسیدن</th><th>قیمت</th><th></th></tr></thead>
      `;
      const tbody = document.createElement('tbody');
      sampleFlights.forEach(f=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${f.id}</td>
          <td>${f.airline}</td>
          <td>${f.depart}</td>
          <td>${f.arrive}</td>
          <td>${f.depart_time}</td>
          <td>${f.arrive_time}</td>
          <td>${f.fare} USD</td>
          <td class="actions">
            <button onclick="viewSeats('${f.id}')">انتخاب صندلی</button>
            <button class="book" onclick="bookFlight('${f.id}')">رزرو</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
      table.appendChild(tbody);
      resultsEl.appendChild(table);
    }

    function viewSeats(flightId){
      // نشان دادن یک seat-map نمونه برای انتخاب صندلی
      const resultsEl = document.getElementById('results');
      resultsEl.innerHTML = '';
      const wrap = document.createElement('div');
      wrap.className = 'card';
      wrap.innerHTML = `<h3 style="margin-top:0">نقشه صندلی — ${flightId}</h3><div class="seatmap" id="seatmap"></div>
        <div style="margin-top:12px;display:flex;justify-content:flex-end;gap:8px">
          <button onclick="searchFlights()">بازگشت</button>
          <button class="primary" onclick="confirmSeat()">تایید صندلی</button>
        </div>
      `;
      resultsEl.appendChild(wrap);

      const seatmap = document.getElementById('seatmap');
      // شبیهسازی 30 صندلی (برخی گرفته شده)
      const taken = new Set(['1A','2B','5C']);
      for(let r=1;r<=5;r++){
        for(let c=1;c<=6;c++){
          const seatNo = `${r}${String.fromCharCode(64+c)}`; // 1A,1B,...
          const s = document.createElement('div');
          s.className = 'seat';
          if(taken.has(seatNo)) s.classList.add('taken');
          s.textContent = seatNo;
          s.onclick = ()=> {
            if(s.classList.contains('taken')) return;
            document.querySelectorAll('.seat.selected').forEach(el=>el.classList.remove('selected'));
            s.classList.toggle('selected');
          };
          seatmap.appendChild(s);
        }
      }
    }

    function confirmSeat(){
      const sel = document.querySelector('.seat.selected');
      if(!sel){ alert('لطفاً یک صندلی انتخاب کنید.'); return; }
      // در عمل: ارسال رزرو به بکاند (reservation.create)
      alert('صندلی '+sel.textContent+' انتخاب شد — ادامهٔ فرآیند پرداخت در بکاند');
    }

    function bookFlight(flightId){
      // باز کردن فرم رزرو ساده
      const resultsEl = document.getElementById('results');
      resultsEl.innerHTML = '';
      const formCard = document.createElement('div');
      formCard.className = 'card';
      formCard.innerHTML = `
        <h3 style="margin-top:0">فرم رزرو — ${flightId}</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
          <div><label>نام</label><input id="fname" /></div>
          <div><label>نام خانوادگی</label><input id="lname" /></div>
          <div><label>شماره تماس</label><input id="phone" /></div>
          <div><label>ایمیل</label><input id="email" /></div>
        </div>
        <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end">
          <button onclick="searchFlights()">انصراف</button>
          <button class="primary" onclick="submitReservation('${flightId}')">تایید و پرداخت</button>
        </div>
      `;
      resultsEl.appendChild(formCard);
    }

    function submitReservation(flightId){
      // نمونه اعتبارسنجی و ارسال
      const fname = document.getElementById('fname').value.trim();
      if(!fname){ alert('نام را وارد کنید'); return; }
      // در پروژهٔ واقعی: POST به /api/reservations با payload شامل Passenger و FlightID و SeatID
      alert('رزرو شما ثبت شد (نمونه). اتصال به سرور را پیاده کنید.');
      searchFlights();
    }

    function openLogin(){
      alert('فرم ورود مدیریت (نمونه). میتوانید این بخش را به صفحهٔ ورود جداگانه متصل کنید.');
    }
  </script>
</body>
</html>
