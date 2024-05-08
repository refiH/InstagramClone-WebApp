function formatTime(date) {
  const now = new Date();
  const createdDate = new Date(date);

  const timeDiff = Math.abs(now - createdDate);

  const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
  const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

  let result = '';
  if (days > 0) {
    result = days + 'd';
  } else if (hours > 0) {
    result = hours + 'hr';
  } else if (minutes > 0) {
    result = minutes + 'm';
  } else {
    result = seconds + 's';
  }

  result = result.replace(/,\s*$/, '');

  return result;
}

export default formatTime;
