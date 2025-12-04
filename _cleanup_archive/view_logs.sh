#!/bin/bash
# Log Viewer Script for Inmunoflam Website

LOG_FILE="www/www/logs/debug.log"

# Colors for output
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to display usage
usage() {
    echo "Usage: $0 [command] [options]"
    echo ""
    echo "Commands:"
    echo "  follow          - Follow logs in real-time (like tail -f)"
    echo "  last [N]        - Show last N lines (default: 50)"
    echo "  errors          - Show only ERROR level logs"
    echo "  warnings        - Show only WARNING level logs"
    echo "  info            - Show only INFO level logs"
    echo "  search <text>   - Search for specific text in logs"
    echo "  request <id>    - Show all logs for a specific request ID"
    echo "  clear           - Clear the log file"
    echo ""
    echo "Examples:"
    echo "  $0 follow"
    echo "  $0 last 100"
    echo "  $0 errors"
    echo "  $0 search 'page_type'"
    exit 1
}

# Check if log file exists
if [ ! -f "$LOG_FILE" ]; then
    if [ "$COMMAND" != "follow" ]; then
        echo -e "${YELLOW}Log file not found: $LOG_FILE${NC}"
        echo "The log file will be created when you access the website."
        echo "You can try running './fix_permissions.sh' if you suspect permission issues."
        exit 1
    fi
fi

# Parse command
COMMAND=${1:-last}

case "$COMMAND" in
    follow)
        echo -e "${GREEN}Following logs (Ctrl+C to stop)...${NC}"
        if [ ! -f "$LOG_FILE" ]; then
             echo -e "${YELLOW}Waiting for log file to be created...${NC}"
        fi
        # Use -F to retry if file doesn't exist or is rotated
        tail -F "$LOG_FILE" | while read line; do
            if [[ $line == *"ERROR"* ]]; then
                echo -e "${RED}$line${NC}"
            elif [[ $line == *"WARNING"* ]]; then
                echo -e "${YELLOW}$line${NC}"
            elif [[ $line == *"INFO"* ]]; then
                echo -e "${GREEN}$line${NC}"
            else
                echo "$line"
            fi
        done
        ;;
    
    last)
        LINES=${2:-50}
        echo -e "${GREEN}Showing last $LINES lines...${NC}"
        tail -n "$LINES" "$LOG_FILE"
        ;;
    
    errors)
        echo -e "${RED}Showing ERROR logs...${NC}"
        grep "ERROR" "$LOG_FILE" | tail -n 50
        ;;
    
    warnings)
        echo -e "${YELLOW}Showing WARNING logs...${NC}"
        grep "WARNING" "$LOG_FILE" | tail -n 50
        ;;
    
    info)
        echo -e "${GREEN}Showing INFO logs...${NC}"
        grep "INFO" "$LOG_FILE" | tail -n 50
        ;;
    
    search)
        if [ -z "$2" ]; then
            echo -e "${RED}Please provide search text${NC}"
            usage
        fi
        echo -e "${BLUE}Searching for: $2${NC}"
        grep -i "$2" "$LOG_FILE" | tail -n 50
        ;;
    
    request)
        if [ -z "$2" ]; then
            echo -e "${RED}Please provide request ID${NC}"
            usage
        fi
        echo -e "${BLUE}Showing logs for request: $2${NC}"
        grep "$2" "$LOG_FILE"
        ;;
    
    clear)
        echo -e "${YELLOW}Clearing log file...${NC}"
        > "$LOG_FILE"
        echo -e "${GREEN}Log file cleared${NC}"
        ;;
    
    *)
        echo -e "${RED}Unknown command: $COMMAND${NC}"
        usage
        ;;
esac
