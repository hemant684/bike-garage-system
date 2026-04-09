const Footer = () => {
  return (
    <footer className="footer">
      <div className="container">
        <p>&copy; 2024 Bike Garage Management System. All rights reserved.</p>
        <p style={{marginTop: '10px', fontSize: '0.9rem'}}>
          <a href="/about">About</a> | 
          <a href="/services">Services</a> | 
          <a href="/faq">FAQ</a> | 
          <a href="/contact">Contact</a>
        </p>
        <p style={{marginTop: '5px', fontSize: '0.85rem'}}>
          <a href="/privacy">Privacy Policy</a> | 
          <a href="/terms">Terms & Conditions</a>
        </p>
      </div>
    </footer>
  );
};

export default Footer;
