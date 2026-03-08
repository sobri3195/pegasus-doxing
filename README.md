# Pegasus Doxing - OSINT Tool

Pegasus Doxing is an OSINT (Open Source Intelligence) tool written in PHP to gather information about a target based on name, username, email, phone number, or domain indicators.

## Features

### Core modules
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

### New modules
- **BreachRadar**: Exposure and breach footprint triage
- **DomainIntel**: Domain ownership and infrastructure profiling
- **DarkMention**: Dark-web mention risk indicators
- **PhoneCarrier**: Carrier and line type profiling
- **KeywordPulse**: Keyword trend and context pulse
- **NetworkGraph**: Entity relation graph seed builder
- **ReputationScore**: Behavioral and trust scoring model
- **DocSnapshot**: Public document trace and metadata snapshot
- **EventTrace**: Event and timeline correlation
- **ProfileMatcher**: Cross-profile similarity matching

## Platform improvements
- Dynamic module registry to keep UI and processing in sync
- Safer module execution (only registered modules can run)
- Better form UX (selected modules and input are preserved)
- Automatic log directory creation if not present

## Installation

1. Clone the repository:
```bash
git clone https://github.com/sobri3195/pegasus-doxing.git
```

2. Ensure PHP 7.4+ is installed on your system.

3. Install required PHP extensions:
```bash
sudo apt-get install php-curl php-mbstring php-xml
```

4. Configure your web server to point to the project directory.

## Usage

1. Access the web interface through your browser.
2. Enter the target information (name, username, email, phone number, or domain).
3. Select one or more modules.
4. Click **Search**.
5. View results and download JSON log output.

## Output

Results are displayed in HTML and exported to `output/logs/`.

## License

This project is licensed under the MIT License. See `LICENSE` for details.

## Disclaimer

This tool is for educational and authorized security testing purposes only. Use it responsibly and in accordance with applicable laws and regulations.
