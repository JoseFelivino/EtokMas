const MONTHS = [
  {
    name: 'Januari',
    shortName: 'Jan',
  },
  {
    name: 'Februari',
    shortName: 'Feb',
  },
  {
    name: 'Maret',
    shortName: 'Mar',
  },
  {
    name: 'April',
    shortName: 'Apr',
  },
  {
    name: 'Mei',
    shortName: 'Mei',
  },
  {
    name: 'June',
    shortName: 'Jun',
  },
  {
    name: 'July',
    shortName: 'Jul',
  },
  {
    name: 'Agustus',
    shortName: 'Aug',
  },
  {
    name: 'September',
    shortName: 'Sep',
  },
  {
    name: 'Oktober',
    shortName: 'Oct',
  },
  {
    name: 'November',
    shortName: 'Nov',
  },
  {
    name: 'Desember',
    shortName: 'Des',
  },
];

const GetDateAndTime = (timeFormat) => {
  const [ date, time ] = timeFormat.split(/[ ]/);

  return {
    date,
    time,
  };
}

const GetDMY = (timeFormat) => {
  const [ day, month, year ] = timeFormat.split(/[.,\/ -]/);

  return {
    day,
    month,
    year,
  };
}

const DateForHtml = (timeFormat) => {
  const { date } = GetDateAndTime(timeFormat);

  const { day, month, year } = GetDMY(date)
  return `${year}-${month}-${day}`;
}

const DateForPage = (timeFormat) => {
  if (!DateForPage) {
    return 'tidak ada'
  }
  const { date, time } = GetDateAndTime(timeFormat);
  const { day, month, year } = GetDMY(date);

  return `${day} ${MONTHS[month-1].shortName} ${year} ${time ?? ''}`;
}

export {
  DateForHtml,
  DateForPage,
};
