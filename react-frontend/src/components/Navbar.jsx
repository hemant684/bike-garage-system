import Link from 'next/link'

const Navbar = () => {
  const backendUrl = process.env.NEXT_PUBLIC_PHP_BACKEND_URL ?? ''

  return (
    <nav className="navbar">
      <div className="container">
        <Link href="/" className="navbar-brand">
          <i className="fas fa-motorcycle"></i> Bike Garage
        </Link>
        <ul className="nav-links" aria-label="Main navigation">
          <li><Link href="/">Home</Link></li>
          <li><Link href="/services">Services</Link></li>
          <li><Link href="/book-service">Book service</Link></li>
          <li><Link href="/login">Login</Link></li>
          <li><Link href="/register" className="nav-register">Get started</Link></li>
          <li><a href={`${backendUrl}/admin_login.php`}>Admin</a></li>
        </ul>
      </div>
    </nav>
  );
};

export default Navbar;
