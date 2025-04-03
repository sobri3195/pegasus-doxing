# Pegasus Doxing - OSINT Tool

Pegasus Doxing is a powerful OSINT (Open Source Intelligence) tool written in PHP that helps gather comprehensive information about a target based on various inputs like name, username, email, or phone number.

## Features

- **Doxid**: Identity and relationship search based on name
- **Webbio**: Public web biography search
- **UsernameDNA**: Username pattern tracking across platforms
- **Geopost**: Geographic location detection from posts
- **WhatsApp Check**: WhatsApp number verification
- **TimePattern**: Online activity time pattern analysis
- **EmailCross**: Cross-platform email footprint search
- **ExifScan**: EXIF data extraction from images
- **SocialSigs**: Social media signal mapping
- **RedirectChain**: Link redirect chain tracking

## Installation

1. Clone the repository:
```bash
git clone https://github.com/sobri3195/pegasus-doxing.git
```

2. Ensure PHP 7.4+ is installed on your system

3. Install required PHP extensions:
```bash
sudo apt-get install php-curl php-mbstring php-xml
```

4. Configure your web server to point to the project directory

## Usage

1. Access the web interface through your browser
2. Enter the target information (name, username, email, or phone number)
3. Select the modules you want to run
4. Click "Search" to start the OSINT process
5. View and download the results

## Output

Results are displayed in a clean HTML format and can be downloaded as logs. All findings are stored in `output/logs/` for future reference.

## Author

**Letda Kes Dr. Sobri, S.Kom**
- Email: muhammadsobrimaulana31@gmail.com
- GitHub: [sobri3195](https://github.com/sobri3195)

## Support

If you find this tool useful, consider supporting the development:

[![Donate](https://img.shields.io/badge/Donate-Link-blue)](https://lynk.id/muhsobrimaulana)

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Disclaimer

This tool is for educational and authorized security testing purposes only. Use it responsibly and in accordance with applicable laws and regulations. 