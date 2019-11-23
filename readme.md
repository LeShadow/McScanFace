***This is currently a proof of concept. An alpha/beta version is planned for this quarter, hopefully before Chaos Communication Congress***
## McScanFace
*McScanFace, an interface for masscan. McScanFace introduces you to a new, distributed way of using masscan by spreading the workload over multiple servers from a simple webinterface. Features that will be included at the time of the presentation: prepare servers for scans, distributing workload over multiple servers, report compilation. Features planned: Export data to a server of your choice, export data to search/analytics engines (Eg. Elasticsearch).*

-

Requirements: *(These are the platform(s) I tested it on, feel free to test it on other platforms and let me know if it works! I'll add them to the list)*

- PHP 7.3.7+
- PostgreSQL

-

Feel free to add suggestions for new features or improvements to the codebase in the issue tracker!

Current features planned:

- Create AWS EC2 instances from within the interface (By using the AWS PHP SDK)
- Creare Azure computing instances from within the interface
- Log different statuses for scans so it is easier to follow up when a scan goes wrong
- Add multi-user capabilities. So more than one user can use the platform
- Export results to Elasticsearch instances


- Shadow 
