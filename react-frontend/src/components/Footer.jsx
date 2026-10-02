import Link from 'next/link'

const Footer = () => {
  return (
    <footer className="footer">
      <div className="container">
        <p>&copy; {new Date().getFullYear()} Bike Garage. Built for the road ahead.</p>
        <p style={{marginTop: '10px', fontSize: '0.9rem'}}>
          <Link href="/">Home</Link>
          {' · '}
          <Link href="/services">Services</Link>
          {' · '}
          <Link href="/login">Login</Link>
          {' · '}
          <a href="mailto:info@bikegarage.com">Contact</a>
        </p>
      </div>
    </footer>
  );
};

export default Footer;
