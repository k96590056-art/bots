// Polyfill for Node.js 12+ where http_parser binding was removed
// Used to fix webpack-dev-server v2 / spdy / http-deceiver issues

const process = require('process');

// Only polyfill if it's missing
try {
    process.binding('http_parser');
} catch (e) {
    // Only apply if the error is about missing module, though process.binding usually throws specific errors
    if (e.message.indexOf('No such module') !== -1) {
        const originalBinding = process.binding;
        process.binding = function (name) {
            if (name === 'http_parser') {
                return {
                    HTTPParser: {
                        methods: [
                            'DELETE', 'GET', 'HEAD', 'POST', 'PUT', 'CONNECT', 'OPTIONS', 'TRACE',
                            'COPY', 'LOCK', 'MKCOL', 'MOVE', 'PROPFIND', 'PROPPATCH', 'SEARCH',
                            'UNLOCK', 'BIND', 'REBIND', 'UNBIND', 'ACL', 'REPORT', 'MKACTIVITY',
                            'CHECKOUT', 'MERGE', 'M-SEARCH', 'NOTIFY', 'SUBSCRIBE', 'UNSUBSCRIBE',
                            'PATCH', 'PURGE', 'MKCALENDAR', 'LINK', 'UNLINK'
                        ],
                        kOnHeaders: 0,
                        kOnHeadersComplete: 1,
                        kOnBody: 2,
                        kOnMessageComplete: 3,
                        kOnExecute: 4
                    }
                };
            }
            return originalBinding.call(process, name);
        };
    }
}
