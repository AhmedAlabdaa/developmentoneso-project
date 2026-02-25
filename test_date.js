const testDates = [
  "2026-02-21",
  "2026-02-18",
  "21 Feb 2026"
];

function formatDateForInput(dateVal) {
  if (!dateVal) return '';
  let str = String(dateVal).trim();
  if (!str) return '';

  if (str.length >= 10 && str.charAt(4) === '-' && str.charAt(7) === '-') {
      return str.substring(0, 10);
  }

  const months = {
    'jan': '01', 'feb': '02', 'mar': '03', 'apr': '04', 'may': '05', 'jun': '06',
    'jul': '07', 'aug': '08', 'sep': '09', 'oct': '10', 'nov': '11', 'dec': '12'
  };
  const parts = str.split(/[\s,-]+/);
  if (parts.length >= 3) {
      const mStr = parts[1].toLowerCase().substring(0, 3);
      if (months[mStr] && parts[0].length <= 2 && parts[2].length === 4) {
          const day = parts[0].length === 1 ? '0' + parts[0] : parts[0];
          return `${parts[2]}-${months[mStr]}-${day}`;
      }
  }

  const d = new Date(str);
  if (!isNaN(d.getTime())) {
      const year = d.getFullYear();
      let month = '' + (d.getMonth() + 1);
      let day = '' + d.getDate();
      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;
      return [year, month, day].join('-');
  }

  return '';
}

for (let d of testDates) {
  console.log(d, "=>", formatDateForInput(d));
}
