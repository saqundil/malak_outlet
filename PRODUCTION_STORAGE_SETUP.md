# Production Storage Setup for Railway

## Problem
Images uploaded locally don't appear on production server because they're stored in local file system.

## Solution 1: AWS S3 Storage (Recommended)

### 1. Install AWS SDK
```bash
composer require league/flysystem-aws-s3-v3
```

### 2. Add to .env (both local and production)
```env
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name
AWS_URL=https://your_bucket.s3.amazonaws.com

# For production, set this in Railway environment variables
FILESYSTEM_DISK=s3
```

### 3. Update config/filesystems.php (already configured)
The S3 configuration is already in place.

### 4. Railway Environment Variables
Set these in your Railway project:
- `FILESYSTEM_DISK=s3`
- `AWS_ACCESS_KEY_ID=your_key`
- `AWS_SECRET_ACCESS_KEY=your_secret`
- `AWS_DEFAULT_REGION=us-east-1`
- `AWS_BUCKET=your_bucket_name`

## Solution 2: Railway Volume Storage

### 1. Create a Volume in Railway
- Go to your Railway project
- Add a Volume service
- Mount it to `/app/storage/app/public`

### 2. Update Railway deployment
- Ensure storage link is created during deployment

## Solution 3: Cloudinary (Alternative)

### 1. Install Cloudinary
```bash
composer require cloudinary/cloudinary_php
```

### 2. Configure Cloudinary storage driver
Add custom driver to AppServiceProvider

## Quick Fix for Current Issue

### Upload the missing image manually:
1. Copy the local image: `storage/app/public/products/1760959688_0_.png`
2. Upload it to your Railway app via FTP or deployment
3. Or re-upload through production admin panel

## Database Sync
Make sure your production database has the correct image records. You may need to:
1. Export your local database
2. Import to production
3. Or manually create the product with images on production