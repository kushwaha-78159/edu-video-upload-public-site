# 🎓 EDUCAST - Educational Video Sharing Platform

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4)
![License](https://img.shields.io/badge/license-MIT-green)
![Platform](https://img.shields.io/badge/platform-Windows%20|%20Linux%20|%20Mac-lightgrey)

> **Share Knowledge, Learn Together** - A simple yet powerful platform where anyone can upload educational videos and anyone can watch them. No login required, no signup hassle. Just pure learning!

## 📖 Table of Contents
- [✨ Features](#-features)
- [🖼️ Screenshots](#️-screenshots)
- [📁 Project Structure](#-project-structure)
- [💻 System Requirements](#-system-requirements)
- [🚀 Installation Guide](#-installation-guide)
  - [Windows Installation](#windows-installation)
  - [Linux/Ubuntu Installation](#linuxubuntu-installation)
  - [macOS Installation](#macos-installation)
- [⚙️ Configuration](#️-configuration)
- [🎯 How to Use](#-how-to-use)
- [📡 API Endpoints](#-api-endpoints)
- [🐛 Troubleshooting](#-troubleshooting)
- [🆘 FAQ](#-faq)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)

---

## ✨ Features

### Core Features
| Feature | Description |
|---------|-------------|
| 🎥 **Video Upload** | Upload any educational video (MP4, WebM, MKV - up to 128MB) |
| 👀 **Video Watching** | Watch uploaded videos directly in browser |
| 🔍 **Search Videos** | Search videos by title or description |
| 📊 **View Counter** | Automatic view count tracking for each video |
| 🖼️ **Thumbnail Support** | Add custom thumbnails for your videos |
| 📂 **Categories** | Browse videos by category (Programming, Science, Business, etc.) |
| 📱 **Responsive Design** | Works perfectly on mobile, tablet, and desktop |
| 🔓 **No Login Required** | Anyone can upload and watch without registration |

### User Benefits
- ✅ **Zero Registration** - Direct upload and watch
- ✅ **Instant Publishing** - Videos appear immediately on homepage
- ✅ **No Approval Needed** - Upload and share instantly
- ✅ **Completely Free** - No charges, no hidden fees
- ✅ **Educational Focus** - Dedicated to learning content

---

## 🖼️ Screenshots

### Home Page
![Home Page](https://via.placeholder.com/800x400?text=Home+Page+-+Video+Gallery)

### Upload Page
![Upload Page](https://via.placeholder.com/800x400?text=Upload+Page)

### Video Player
![Video Player](https://via.placeholder.com/800x400?text=Video+Player)

---

## 📁 Project Structure
educast/
│
├── 📄 index.html # Home page - shows all videos
├── 📄 upload.html # Video upload page
├── 📄 video-player.html # Video watching page
├── 📄 upload_handler.php # PHP backend for video upload
├── 📄 get_videos.php # API to fetch all videos
├── 📄 videos.json # Database file (stores video metadata)
│
├── 📁 css/
│ └── 📄 style.css # Styling for all pages
│
├── 📁 js/
│ └── 📄 app.js # JavaScript for dynamic features
│
├── 📁 uploads/ # Uploaded files directory
│ ├── 📁 videos/ # Store uploaded video files
│ └── 📁 thumbnails/ # Store thumbnail images
│
└── 📄 README.md # This documentation


---

## 💻 System Requirements

### Minimum Requirements
| Component | Requirement |
|-----------|-------------|
| **OS** | Windows 7/8/10/11, Linux (Ubuntu 18.04+), macOS 10.13+ |
| **Web Server** | Apache 2.4+ (via XAMPP/WAMP/LAMP) |
| **PHP** | Version 7.4 or higher |
| **Storage** | 500MB free space (more for videos) |
| **RAM** | 2GB minimum |
| **Browser** | Chrome 80+, Firefox 75+, Edge 80+, Safari 13+ |

### Recommended Requirements
| Component | Recommendation |
|-----------|----------------|
| **CPU** | Dual-core 2.0GHz+ |
| **RAM** | 4GB or more |
| **Storage** | 10GB+ for video storage |
| **Internet** | 10Mbps+ for smooth uploads |

---

## 🚀 Installation Guide

### Windows Installation (XAMPP)

#### Step 1: Install XAMPP
```bash
1. Download XAMPP from: https://www.apachefriends.org/
2. Run the installer
3. Select components: Apache, PHP
4. Install to: C:\xampp
5. Complete installation
