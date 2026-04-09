#!/bin/bash

# Bike Garage System - GitHub Push Helper
# This script helps you push your code to GitHub

echo "╔════════════════════════════════════════════════════════════╗"
echo "║     Bike Garage System - GitHub Push Helper               ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Check if git is initialized
if [ ! -d .git ]; then
    echo "❌ Git repository not initialized!"
    echo "Run: git init"
    exit 1
fi

echo "📋 INSTRUCTIONS:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "1. Go to: https://github.com/hemant684"
echo "2. Click '+' icon → 'New repository'"
echo "3. Name it: bike-garage-system"
echo "4. DO NOT check 'Initialize with README'"
echo "5. Click 'Create repository'"
echo ""
echo "⏳ After creating on GitHub, enter your repository URL:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
read -p "Enter GitHub repository URL: " GITHUB_URL

if [ -z "$GITHUB_URL" ]; then
    echo "❌ No URL provided!"
    exit 1
fi

echo ""
echo "🔗 Adding remote..."
git remote add origin "$GITHUB_URL"

echo "✅ Remote added!"
echo ""
echo "📤 Pushing to GitHub..."
git push -u origin main

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ SUCCESS! Your code is now on GitHub!"
    echo ""
    echo "🎉 NEXT STEPS:"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "1. Go to https://netlify.com"
    echo "2. Sign up with GitHub"
    echo "3. Click 'Add new site' > 'Import an existing project'"
    echo "4. Select: bike-garage-system"
    echo "5. Netlify will auto-detect settings and deploy!"
    echo ""
    echo "Your site will be live at: https://your-site.netlify.app"
else
    echo "❌ Push failed! Check your URL and try again."
    exit 1
fi
