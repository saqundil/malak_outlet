# Quick Setup for AWS S3 Storage

## 1. Create AWS S3 Bucket
- Go to AWS Console
- Create S3 bucket (e.g., "malak-outlet-images")
- Set public read permissions for images

## 2. Get AWS Credentials
- Create IAM user with S3 permissions
- Get Access Key ID and Secret Access Key

## 3. Set Railway Environment Variables
In your Railway project settings, add:
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_access_key_here
AWS_SECRET_ACCESS_KEY=your_secret_key_here
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=malak-outlet-images
AWS_URL=https://malak-outlet-images.s3.amazonaws.com
```

## 4. Local .env file
Add the same variables to your local .env file for testing

## 5. Test
After setup, new images will be stored in S3 and accessible from both local and production.