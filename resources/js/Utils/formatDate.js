function formatDate(date) {
  const formatted = new Date(date).toLocaleDateString('en-UK', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  });

  return formatted;
}

export default formatDate;
