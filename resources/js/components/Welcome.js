import React from 'react';
import PropTypes from 'prop-types';

import Topbar from './Topbar';
import { withStyles } from '@material-ui/core';
import { withRouter } from 'react-router-dom';

const propTypes = {};

const defaultProps = {};

const backgroundShape = require('../images/shape.svg');

const styles = theme => ({
	root: {
		flexGrow: 1,
		backgroundColor: theme.palette.grey['100'],
		overflow: 'hidden',
		background: `url(${backgroundShape}) no-repeat`,
		backgroundSize: 'cover',
		backgroundPosition: '0 400px',
		paddingBottom: 200
	},
	grid: {
		width: 1200,
		margin: `0 ${theme.spacing.unit * 2}px`,
		[theme.breakpoints.down('sm')]: {
			width: 'calc(100% - 20px)'
		}
	},
	loadingState: {
		opacity: 0.05
	},
	paper: {
		padding: theme.spacing.unit * 3,
		textAlign: 'left',
		color: theme.palette.text.secondary
	},
	rangeLabel: {
		display: 'flex',
		justifyContent: 'space-between',
		paddingTop: theme.spacing.unit * 2
	},
	topBar: {
		display: 'flex',
		justifyContent: 'space-between',
		alignItems: 'center'
	},
	outlinedButtom: {
		textTransform: 'uppercase',
		margin: theme.spacing.unit
	},
	actionButtom: {
		textTransform: 'uppercase',
		margin: theme.spacing.unit,
		width: 152,
		height: 36
	},
	blockCenter: {
		padding: theme.spacing.unit * 2,
		textAlign: 'center'
	},
	block: {
		padding: theme.spacing.unit * 2
	},
	loanAvatar: {
		display: 'inline-block',
		verticalAlign: 'center',
		width: 16,
		height: 16,
		marginRight: 10,
		marginBottom: -2,
		color: theme.palette.primary.contrastText,
		backgroundColor: theme.palette.primary.main
	},
	interestAvatar: {
		display: 'inline-block',
		verticalAlign: 'center',
		width: 16,
		height: 16,
		marginRight: 10,
		marginBottom: -2,
		color: theme.palette.primary.contrastText,
		backgroundColor: theme.palette.primary.light
	},
	inlining: {
		display: 'inline-block',
		marginRight: 10
	},
	buttonBar: {
		display: 'flex'
	},
	noBorder: {
		borderBottomStyle: 'hidden'
	},
	mainBadge: {
		textAlign: 'center',
		marginTop: theme.spacing.unit * 4,
		marginBottom: theme.spacing.unit * 4
	}
});

function Welcome(props) {
	return (
		<React.Fragment>
			<Topbar />
		</React.Fragment>
	);
}

export default withRouter(withStyles(styles)(Welcome));

Welcome.propTypes = propTypes;
Welcome.defaultProps = defaultProps;
