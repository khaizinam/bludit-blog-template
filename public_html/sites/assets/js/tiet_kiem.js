function fmt(n) {
  return new Intl.NumberFormat('vi-VN').format(Math.round(n));
}
function fmtShort(n) {
  if (n >= 1e9) return (n/1e9).toFixed(2) + ' tỷ';
  if (n >= 1e6) return (n/1e6).toFixed(2) + ' tr';
  return fmt(n);
}

function calculate(userTriggered = false) {
  const amount = parseFloat(document.getElementById('inp-amount').value) || 0;
  const years  = parseInt(document.getElementById('inp-term').value) || 3;
  const rate   = parseFloat(document.getElementById('inp-rate').value) || 0;
  const bank   = document.getElementById('inp-bank').value.trim() || 'Ngân hàng';

  if (amount <= 0 || rate <= 0) {
    alert('Vui lòng nhập số tiền và lãi suất hợp lệ!');
    return;
  }

  const totalMonths = years * 12;
  const ratePerMonth = rate / 100 / 12;

  let rows = [];
  let cumVon = 0;
  let cumLai = 0;

  for (let m = 1; m <= totalMonths; m++) {
    const remaining = totalMonths - m + 1; // số tháng tính lãi
    const laiThisDeposit = amount * (rate / 100) * remaining / 12;
    cumVon += amount;
    cumLai += laiThisDeposit;
    rows.push({
      month: m,
      deposit: amount,
      remaining: remaining,
      cumVon: cumVon,
      laiThisDeposit: laiThisDeposit,
      cumLai: cumLai,
      total: cumVon + cumLai
    });
  }

  const totalVon = amount * totalMonths;
  const totalLai = rows[rows.length - 1].cumLai;
  const grandTotal = totalVon + totalLai;
  const pct = (totalLai / totalVon * 100);
  const vonPct = (totalVon / grandTotal * 100).toFixed(1);
  const laiPct = (totalLai / grandTotal * 100).toFixed(1);

  // Show result
  document.getElementById('result').classList.remove('hidden');

  // Summary
  document.getElementById('s-von').textContent = fmt(totalVon) + ' ₫';
  document.getElementById('s-von-sub').textContent = `${fmt(amount)} ₫ × ${totalMonths} tháng`;
  document.getElementById('s-lai').textContent = fmt(totalLai) + ' ₫';
  document.getElementById('s-lai-sub').textContent = `Lãi suất ${rate}%/năm`;
  document.getElementById('s-total').textContent = fmt(grandTotal) + ' ₫';
  document.getElementById('s-total-sub').textContent = `Sau ${years} năm gửi góp`;
  document.getElementById('s-pct').textContent = pct.toFixed(2) + '%';

  // Progress bars
  setTimeout(() => {
    document.getElementById('prog-von').style.width = Math.min(100, vonPct) + '%';
    document.getElementById('prog-lai').style.width = Math.min(100, laiPct * 3) + '%';
    document.getElementById('prog-pct').style.width = Math.min(100, pct * 3) + '%';
    document.getElementById('bar-von').style.width = vonPct + '%';
    document.getElementById('bar-lai').style.width = laiPct + '%';
  }, 100);

  document.getElementById('bar-von-pct').textContent = vonPct + '%';
  document.getElementById('bar-lai-pct').textContent = laiPct + '%';
  document.getElementById('bar-title').textContent =
    `${bank} — Gửi ${fmt(amount)}₫/tháng × ${totalMonths} tháng @ ${rate}%/năm`;

  // Table title & tags
  document.getElementById('tbl-title').textContent =
    `${bank} | ${fmt(amount)} ₫/tháng | ${rate}%/năm | ${years} năm`;
  document.getElementById('tbl-tags').innerHTML =
    `<span class="tag tag-green">${totalMonths} tháng</span>
     <span class="tag tag-blue">Tất toán: ${fmtShort(grandTotal)} ₫</span>`;

  // Table rows
  const tbody = document.getElementById('tbl-body');
  tbody.innerHTML = '';
  rows.forEach((r, i) => {
    const isLast = i === rows.length - 1;
    const tr = document.createElement('tr');
    if (isLast) tr.className = 'last-row';

    // Month label
    const yr = Math.ceil(r.month / 12);
    const mo = r.month % 12 === 0 ? 12 : r.month % 12;
    const label = isLast
      ? `<span style="color:#00f5b8;font-weight:700">🏁 Tháng ${r.month}</span>`
      : `Năm ${yr} – T${mo < 10 ? '0'+mo : mo}`;

    tr.innerHTML = `
      <td>${label}</td>
      <td class="cum-von">${fmt(r.deposit)} ₫</td>
      <td style="color:#7d8590">${r.remaining} tháng</td>
      <td class="cum-von">${fmt(r.cumVon)} ₫</td>
      <td class="lai-thang">${fmt(r.laiThisDeposit)} ₫</td>
      <td class="cum-lai">${fmt(r.cumLai)} ₫</td>
      <td class="${isLast ? 'tong' : 'cum-lai'}">${fmt(r.total)} ₫</td>
    `;
    tbody.appendChild(tr);
  });

  // Scroll to result only when user explicitly triggered
  if (userTriggered) {
    document.getElementById('result').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}

// Auto calculate on load (no scroll)
window.addEventListener('load', () => calculate(false));

// Recalculate on Enter (with scroll)
document.addEventListener('keydown', e => { if (e.key === 'Enter') calculate(true); });
