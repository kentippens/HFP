#!/bin/bash

# Setup automatic exports via cron
# Run this script to install the Laravel scheduler cron job

echo "Setting up Laravel Task Scheduler for automatic exports..."

# Add the Laravel scheduler to crontab
(crontab -l 2>/dev/null; echo "* * * * * cd /home/txmamba/projects/HexService-Laravel && php artisan schedule:run >> /dev/null 2>&1") | crontab -

echo "✅ Cron job added successfully!"
echo ""
echo "The following exports are now scheduled:"
echo "• Weekly contact submissions export - Mondays at 9:00 AM"
echo "• Monthly full export - 1st of each month at 8:00 AM"
echo "• Daily services export - Daily at 11:30 PM (if services updated)"
echo "• Weekly users export - Fridays at 5:00 PM"
echo ""
echo "To verify the cron job was added, run: crontab -l"
echo "To remove the cron job, run: crontab -e and delete the line"